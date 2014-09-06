<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\Core\Guid;
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
     * @param Guid $eventProviderGuid
     *
     * @return StoreableEventsCollectionInterface
     */
    public function getAllEvents(Guid $eventProviderGuid);

    /**
     * Get all events since last snapshot
     *
     * @param Guid $eventProviderGuid
     *
     * @return StoreableEventsCollectionInterface
     */
    public function getEventsSinceLastSnapShot(Guid $eventProviderGuid);

    /**
     * Get events count since last snapshot
     *
     * @param Guid $eventProviderGuid
     *
     * @return integer
     */
    public function getEventCountSinceLastSnapShot(Guid $eventProviderGuid);

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