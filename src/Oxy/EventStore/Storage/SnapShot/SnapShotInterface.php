<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage\SnapShot;

use Oxy\EventStore\Storage\Memento\MementoInterface;

/**
 * SnapShot storage interface
 *
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
interface SnapShotInterface
{
    /**
     * Return memento
     *
     * @return MementoInterface
     */
    public function getMemento();

    /**
     * Return event provider id
     *
     * @return String
     */
    public function getEventProviderId();

    /**
     * Return version
     *
     * @return integer
     */
    public function getVersion();
}