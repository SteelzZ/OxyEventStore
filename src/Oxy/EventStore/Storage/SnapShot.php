<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Storage
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Storage;

use Oxy\EventStore\Storage\Memento\MementoInterface;
use Oxy\EventStore\Storage\SnapShot\SnapShotInterface;

/**
 * Snapshot
 *
 * @category   Oxy
 * @package    Oxy_EventStore
 * @subpackage Storage
 * @author     Tomas Bartkus <to.bartkus@gmail.com>
 */
class SnapShot implements SnapShotInterface
{
    /**
     * @var String
     */
    private $_eventProviderId;

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
     * @return String
     */
    public function getEventProviderId()
    {
        return $this->_eventProviderId;
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
     * @param String           $eventProviderId
     * @param integer          $version
     * @param MementoInterface $memento
     *
     * @return SnapShot
     */
    public function __construct($eventProviderId, $version, MementoInterface $memento)
    {
        $this->_eventProviderGuid = $eventProviderId;
        $this->_version = $version;
        $this->_memento = $memento;
    }
}