<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage\SnapShotStorage;

use Oxy\Core\Guid;
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
     * @param Guid $eventProviderGuid
     * @param EventProviderInterface $eventProvider
     * 
     * @return SnapShotInterface
     */
    public function getSnapShot(Guid $eventProviderGuid, EventProviderInterface $eventProvider);

    /**
     * Save snapshot
     *
     * @param EventProviderInterface $eventProvider
     * @return void
     */
    public function saveSnapShot(EventProviderInterface $eventProvider);
}