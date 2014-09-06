<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\Core\Guid;
use Oxy\EventStore\Storage\Memento\MementoInterface;
use Oxy\EventStore\Storage\SnapShot\SnapShotInterface;

/**
 * Snapshot
 *
 * @category Oxy
 * @package Oxy_EventStore
 * @subpackage Storage
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
class SnapShot implements SnapShotInterface
{
    /**
     * @var Guid
     */
    private $_eventProviderGuid;

    /**
     * @var Integer
     */
    private $_version;

    /**
     * Memento
     *
     * @var MementoInterface
     */
    private $_memento;

    /**
     * @return Guid
     */
    public function getEventProviderGuid()
    {
        return $this->_eventProviderGuid;
    }

    /**
     * Return memento
     *
     * @return MementoInterface
     */
    public function getMemento()
    {
        return $this->_memento;
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
     * Initialize snapshot
     *
     * @param Guid             $eventProviderGuid
     * @param integer          $version
     * @param MementoInterface $memento
     *
     * @return SnapShot
     */
    public function __construct(Guid $eventProviderGuid, $version, MementoInterface $memento)
    {
        $this->_eventProviderGuid = $eventProviderGuid;
        $this->_version = $version;
        $this->_memento = $memento;
    }
}