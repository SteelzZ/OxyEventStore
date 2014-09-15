<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\EventProvider
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\EventProvider;

use Oxy\EventStore\Event\StoreableEventsCollectionInterface;
use Oxy\EventStore\Storage\Memento\Originator\OriginatorInterface;

/**
 * Interface EventProviderInterface
 *
 * @category Oxy
 * @package  Oxy\EventStore\EventProvider
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface EventProviderInterface extends OriginatorInterface
{
    /**
     * Load events
     *
     * @param StoreableEventsCollectionInterface $domainEvents
     * 
     * @return void
     */
    public function loadEvents(StoreableEventsCollectionInterface $domainEvents);

    /**
     * Update version
     *
     * @param Integer $version
     *
     * @return void
     */
    public function updateVersion($version);

    /**
     * Get version
     *
     * @return integer
     */
    public function getVersion();

    /**
     * Get changes
     *
     * @return StoreableEventsCollectionInterface
     */
    public function getChanges();
    
    /**
     * Return event provider name
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Return id
     * 
     * @return string
     */
    public function getId();
}