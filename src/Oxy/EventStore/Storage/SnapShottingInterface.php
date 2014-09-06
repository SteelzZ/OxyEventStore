<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\EventStore\EventProvider\EventProviderInterface;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
interface SnapShottingInterface
{
    /**
     * @param EventProviderInterface $eventProvider
     *
     * @return boolean
     */
    public function isSnapShotRequired(EventProviderInterface $eventProvider);
}