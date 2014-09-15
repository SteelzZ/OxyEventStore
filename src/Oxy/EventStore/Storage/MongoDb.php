<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\EventStore\Event\ArrayableInterface;
use Oxy\EventStore\Event\StoreableEvent;
use Oxy\EventStore\Event\StoreableEventsCollection;
use Oxy\EventStore\Event\StoreableEventsCollectionInterface;
use Oxy\EventStore\EventProvider\EventProviderInterface;
use Oxy\EventStore\Storage\SnapShot\SnapShotInterface;

/**
 * MongoDB implementation
 *
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
class MongoDb implements StorageInterface
{
	/**
     * @var \MongoDB
     */
    private $_db;

    /**
     * @var integer
     */
    private $_version;

    /**
     * @var string
     */
    protected $_dbName;

    /**
     * @param \MongoClient $db
     * @param string $dbName
     */
    public function __construct(\MongoClient $db, $dbName)
    {
        $this->_db = $db->selectDB($dbName);
        $this->_version = 0;
        $this->_dbName = $dbName;
    }

    /**
     * Return version
     *
     * @return integer
     */
    public function getVersion()
    {
        return $this->_version;
    }
    
    /**
     * Reset version
     */
    public function resetVersion()
    {
        $this->_version = array();
    }   

    /**
     * Get snapshot
     *
     * @param String                 $eventProviderId
     * @param EventProviderInterface $eventProvider
     * 
     * @return SnapShotInterface|null
     */
    public function getSnapShot($eventProviderId, EventProviderInterface $eventProvider)
    {
        try{
            $collection = $this->_db->selectCollection('aggregates');
            /*$query = array(
                "_id" => (string)$eventProviderGuid
            );
            */
            $query = array(
                "en" => (string)$eventProvider->getName(), // en - entityName
                "rei" => (string)$eventProvider->getId(), // rei - realEntityIdentifier
            );
            $cursor = $collection->findOne($query);
            if(is_null($cursor)) {
                return null;
            } else if (!class_exists((string)$cursor['sc'])){
                $this->_version = $cursor['v'];
                return null;
            } else {
                $this->_version = $cursor['v'];
            }
                    
            $snapshot = new SnapShot(
                $cursor['_id'],
                $cursor['v'], 
                new $cursor['sc']((array)$cursor['ss'])
            );
                   
            return $snapshot;
        } catch(\MongoCursorException $ex){
            return null;
        } catch(\MongoConnectionException $ex){
             return null;
        } catch(\MongoGridFSException $ex){
             return null;
        } catch(\MongoException $ex){
             return null;
        } catch (Exception $ex){
            return null;
        } 
    }

    /**
     * Return all events that are related
     * to $eventProviderId
     *
     * @param String $eventProviderId
     *
     * @return StoreableEventsCollectionInterface
     */
    public function getAllEvents($eventProviderId)
    {
        try{
            $events = new StoreableEventsCollection();
            $collection = $this->_db->selectCollection('events');
            $query = array(
                "ag" => (string)$eventProviderId
            );
                                        
            $cursorAtEvents = $collection->find($query);
            if($cursorAtEvents instanceof \MongoCursor){
                $cursorAtEvents->timeout(-1);
                $cursorAtEvents->sort(array('_id' => 1));
                foreach($cursorAtEvents as $eventData) {
                    if(isset($eventData['eg'])){
                        if(class_exists($eventData['ec'])){
                            $events->addEvent(
                                new StoreableEvent(
                                    $eventData['eg'],
                                    new $eventData['ec']($eventData['e'])
                                )
                            );
                        } 
                    } else {
                        if(class_exists($eventData['ec'])){
                            $events->addEvent(
                                new StoreableEvent(
                                    $eventData['ag'],
                                    new $eventData['ec']($eventData['e'])
                                )
                            );
                        } 
                    }
                }     
            }
                   
            return $events;  
        } catch(\MongoCursorException $ex){
            return new StoreableEventsCollection();
        } catch(\MongoConnectionException $ex){
             return new StoreableEventsCollection();
        } catch(\MongoGridFSException $ex){
             return new StoreableEventsCollection();
        } catch(\MongoException $ex){
             return new StoreableEventsCollection();
        } catch (\Exception $ex){
            return new StoreableEventsCollection();
        } 
    }

    /**
     * Get events count since last snapshot
     *
     * @param String $eventProviderId
     *
     * @return integer
     */
    public function getEventCountSinceLastSnapShot($eventProviderId)
    {
        return 0;        
    }

    /**
     * Get events since last snap shot
     *
     * @param String $eventProviderId
     *
     * @return StoreableEventsCollection
     */
    public function getEventsSinceLastSnapShot($eventProviderId)
    {
        //return $this->getAllEvents($eventProviderGuid);
        return new StoreableEventsCollection();
    }

    /**
     * Save events to database
     *
     * @param EventProviderInterface $eventProvider
     *
     * @throws ConcurrencyException
     * @throws CouldNotSaveEventsException
     * @throws CouldNotSaveSnapShotException
     * @throws EntityAlreadyExistsException
     *
     * @return void
     */
    public function save(EventProviderInterface $eventProvider)
    {
        $changes = $eventProvider->getChanges();
        if($changes->count() > 0){
               
            $collection = $this->_db->selectCollection('aggregates');
            $query = array(
                "en" => (string)$eventProvider->getName(), // en - entityName
                "rei" => (string)$eventProvider->getId(), // rei - realEntityIdentifier
            );
            
            $cursor = $collection->findOne($query);            
            if (!$this->_checkVersion($cursor, $eventProvider->getVersion())) {
                throw new ConcurrencyException(
                	sprintf(
                		'Sorry concurrency problem!!'
                    )
                );
            }
            
            if (
                !$this->_isSame(
                    $cursor,
                    $eventProvider->getId(),
                    $eventProvider->getName()
                )
            ) {
                throw new EntityAlreadyExistsException(
                	sprintf(
                		'Entity with id [%s] and name [%s] already exists!',
                	    $eventProvider->getId(),
                	    $eventProvider->getName()
                    )
                );
            }
            
            $result = $this->saveSnapShot($eventProvider); 
            if($result){
                $result = $this->saveChanges($changes, $eventProvider->getId());
                if(!$result){
                    throw new CouldNotSaveEventsException('Could not save events!');
                }
            } else {
                throw new CouldNotSaveSnapShotException('Could not save aggregate!');
            }
        }
    }

    /**
     * Save events to database
     *
     * @param \Oxy\EventStore\Event\StoreableEventsCollectionInterface $events
     * @param String                                                   $id
     *
     * @internal param $StoreableEventsCollectionInterface
     * @return null
     */
    private function saveChanges(StoreableEventsCollectionInterface $events, $id)
    {
        try{
            $collection = $this->_db->selectCollection('events');

            // Add new events
            foreach ($events as $storableEvent) {
                /** @var \Oxy\EventStore\Event\StoreableEventInterface $storableEvent */
                $eventInstance = $storableEvent->getEvent();
                if(!$eventInstance instanceof ArrayableInterface){
                   throw new Exception(
                       sprintf('Event must implement Oxy\EventStore\Event\ArrayableInterface interface')
                   ); 
                }
                $event = (object)$eventInstance->toArray();
                
                if((string)$storableEvent->getProviderId() === (string)$id){
                    $data = array(
                        'd' => date('Y-m-d H:i:s'),
                        'ag' => (string)$id,
                        'e' => $event,
                        'ec' => (string)get_class($eventInstance)
                    );
                } else {
                    $data = array(
                        'd' => date('Y-m-d H:i:s'),
                        'ag' => (string)$id,
                        'eg' => (string)$storableEvent->getProviderId(),
                        'e' => $event,
                        'ec' => (string)get_class($eventInstance)
                    );
                }
                $collection->insert($data, array("safe" => true));
            }
            return true;
        } catch(\MongoCursorException $ex){
            return false;
        } catch(\MongoConnectionException $ex){
             return false;
        } catch(\MongoGridFSException $ex){
             return false;
        } catch(\MongoException $ex){
             return false;
        } catch (Exception $ex){
            return false;
        }
    }

    /**
     * Save snapshot
     *
     * @param EventProviderInterface $eventProvider
     *
     * @return boolean
     */
    public function saveSnapShot(EventProviderInterface $eventProvider)
    {
        try{
            $aggregateCollection = $this->_db->selectCollection('aggregates');
            $memento = $eventProvider->createMemento();    
            //var_dump($memento);
            if(!is_null($memento)){
                $aggregateCollection->update(
                    array("_id" => (string)$eventProvider->getId()),
                    array(
                        '_id' => (string)$eventProvider->getId(),
                        'en' => (string)$eventProvider->getName(),
                        'ss' => (object)$memento->toArray(),
                        'sc' => (string)get_class($memento),
                        'v' => $this->_version + 1
                    ), 
                    array("upsert" => true, "safe" => true)
                );  
            }
            return true;
        } catch(\MongoCursorException $ex){
            return false;
        } catch(\MongoConnectionException $ex){
             return false;
        } catch(\MongoGridFSException $ex){
             return false;
        } catch(\MongoException $ex){
             return false;
        } catch (Exception $ex){
            return false;
        }  
    }

    /**
     * Check for concurrency
     *
     * @param mixed $cursor
     * @param integer $version
     *
     * @return boolean
     */
    private function _checkVersion($cursor, $version)
    {
        try{
            if(is_null($cursor)) {
                $this->_version = 1;
                return true;
            } 
            
            if ((int)$cursor['v'] === (int)$version) {
                $this->_version = (int)$cursor['v'];
                return true;
            } else {
                return false;
            }   
        } catch(\MongoCursorException $ex){
            return false;
        } catch(\MongoConnectionException $ex){
             return false;
        } catch(\MongoGridFSException $ex){
             return false;
        } catch(\MongoException $ex){
             return false;
        } catch(\Exception $ex){
            return false;
        }
    }      

    /**
     * Check for concurency
     *
     * @param mixed  $cursor
     * @param string $id
     * @param string $name
     *
     * @return boolean
     */
    private function _isSame($cursor, $id, $name)
    {
        try{
            if(is_null($cursor)) {
                return true;
            } 
            
            if (
                ((string)$cursor['en'] === (string)$name)
                && ((string)$cursor['_id'] === (string)$id)
            ) {
                return true;
            } else {
                return false;
            }   
        } catch(\MongoCursorException $ex){
            return false;
        } catch(\MongoConnectionException $ex){
             return false;
        } catch(\MongoGridFSException $ex){
             return false;
        } catch(\MongoException $ex){
             return false;
        } catch(\Exception $ex){
            return false;
        }
    }      
}