<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage\SnapShotStorage;

use Oxy\EventStore\EventProvider\EventProviderInterface;
use Oxy\EventStore\Storage\SnapShot\SnapShotInterface;

/**
 * SnapShot storage interface
 *
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface SnapShotStorageInterface
{
    /**
     * Get snapshot
     *
     * @param String                 $eventProviderId
     * @param EventProviderInterface $eventProvider
     * 
     * @return SnapShotInterface
     */
    public function getSnapShot($eventProviderId, EventProviderInterface $eventProvider);

    /**
     * Save snapshot
     *
     * @param EventProviderInterface $eventProvider
     *
     * @return void
     */
    public function saveSnapShot(EventProviderInterface $eventProvider);
}