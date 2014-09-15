<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\EventStore\Event\StoreableEventsCollectionInterface;
use Oxy\EventStore\EventProvider\EventProviderInterface;
use Oxy\EventStore\Storage\SnapShotStorage\SnapShotStorageInterface;

/**
 * Event storage interface
 *
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface StorageInterface extends SnapShotStorageInterface
{
    /**
     * Get all events for event provider
     *
     * @param String $eventProviderId
     *
     * @return StoreableEventsCollectionInterface
     */
    public function getAllEvents($eventProviderId);

    /**
     * Get all events since last snapshot
     *
     * @param String $eventProviderId
     *
     * @return StoreableEventsCollectionInterface
     */
    public function getEventsSinceLastSnapShot($eventProviderId);

    /**
     * Get events count since last snapshot
     *
     * @param String $eventProviderId
     *
     * @return integer
     */
    public function getEventCountSinceLastSnapShot($eventProviderId);

    /**
     * Save event provider events
     *
     * @param EventProviderInterface $eventProvider
     *
     * @return void
     */
    public function save(EventProviderInterface $eventProvider);

    /**
     * Return version
     * 
     * @return integer
     */
    public function getVersion();
}