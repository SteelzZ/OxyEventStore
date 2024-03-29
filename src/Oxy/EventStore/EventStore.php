<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore;

use Oxy\EventStore\EventProvider\EventProviderInterface;
use Oxy\EventStore\Storage\ConcurrencyException;
use Oxy\EventStore\Storage\ConflictSolverInterface;
use Oxy\EventStore\Storage\SnapShot\SnapShotInterface;
use Oxy\EventStore\Storage\SnapShottingInterface;
use Oxy\EventStore\Storage\StorageInterface;

/**
 * Event store
 *
 * @category Oxy
 * @package Oxy_EventStore
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
class EventStore implements EventStoreInterface
{
    /**
     * @var array
     */
    private $_eventProviders;

    /**
     * @var StorageInterface
     */
    private $_domainEventStorage;
    
    /**
     * @var SnapShottingInterface
     */
    private $_snapShottingStrategy;
    
    /**
     * @var ConflictSolverInterface
     */
    private $_conflictSolvingStrategy;

    /**
     * @param StorageInterface $domainEventsStorage
     *
     * @return EventStore
     */
    public function __construct(StorageInterface $domainEventsStorage)
    {
        $this->_domainEventStorage = $domainEventsStorage;
        $this->_eventProviders = array();
    }

    /**
     * Load event provider
     *
     * @param String                 $eventProviderId
     * @param EventProviderInterface $eventProvider
     *
     * @return EventProviderInterface
     */
    public function getById($eventProviderId, EventProviderInterface $eventProvider)
    {
        $this->_loadSnapShotIfExists($eventProviderId, $eventProvider);
        $this->_loadRemainingHistoryEvents($eventProvider);
        $eventProvider->updateVersion($this->_domainEventStorage->getVersion());
        
        return $eventProvider;
    }

    /**
     * @param EventProviderInterface $eventProvider
     * @return void
     */
    public function add(EventProviderInterface $eventProvider)
    {
        $this->_eventProviders[(string)$eventProvider->getId()] = $eventProvider;
    }

    /**
     * Commit all events
     *
     * @throws Storage\ConcurrencyException
     *
     * @return void
     */
    public function commit()
    {
        foreach ($this->_eventProviders as $eventProviderId => $eventProvider){
            
            // Check if there is concurrency problem
            // if so use injected strategy to solve it and save correct event provider
            if((int)$eventProvider->getVersion() !== (int)$this->_domainEventStorage->getVersion($eventProviderId)){
                throw new ConcurrencyException('Concurrency!');

                /*
                 * Perhaps should be enabled at some point ? :)
                 *
                $className = get_class($eventProvider);
                $fromStorage = new $className(new Oxy_Guid($eventProviderGuid));
                $this->getById($eventProviderGuid, $fromStorage);
                
                $eventProvider = $this->_conflictSolvingStrategy->solve(
                    $eventProvider,
                    $fromStorage
                );
                */
            } 
            
            // Use injected snapshotting strategy to check should we do snap shot
            /*
             * Enable no ? :)
            if($this->_snapShottingStrategy->isSnapShotRequired($eventProvider)){
                $this->_domainEventStorage->saveSnapShot($eventProvider);
            } 
            */

            // Save event provider events
            $this->_domainEventStorage->save($eventProvider);
            unset($this->_eventProviders[$eventProviderId]);
        }
    }

    /**
     * Rollback everything
     *
     * @return void
     */
    public function rollback()
    {
        $this->_eventProviders = array();
    }

    /**
     * Load snapshot and return event provider
     *
     * @param String                 $eventProviderId
     * @param EventProviderInterface $eventProvider
     *
     * @return EventProviderInterface
     */
    private function _loadSnapShotIfExists(
        $eventProviderId,
        EventProviderInterface $eventProvider
    )
    {
        $snapShot = $this->_domainEventStorage->getSnapShot($eventProviderId, $eventProvider);
        if (!($snapShot instanceof SnapShotInterface)) {
            return $eventProvider;
        }
        $memento = $snapShot->getMemento();

        $eventProvider->setMemento($memento);
        return $eventProvider;
    }

    /**
     * Return aggregate root
     *
     * @param EventProviderInterface $eventProvider
     *
     * @return EventProviderInterface
     */
    private function _loadRemainingHistoryEvents(EventProviderInterface $eventProvider)
    {
        $domainEvents = $this->_domainEventStorage->getEventsSinceLastSnapShot($eventProvider->getId());
        $eventProvider->loadEvents($domainEvents);
        return $eventProvider;
    }
}