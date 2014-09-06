<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Event;

use Oxy\Core\Guid;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
class StoreableEvent implements StoreableEventInterface
{
    /**
     * @var Guid
     */
    private $_providerGuid;

    /**
     * @var EventInterface
     */
    private $_event;

    /**
     * Init
     *
     * @param Guid $providerGuid
     * @param EventInterface $event
     *
     * @return StoreableEvent
     */
    public function __construct(
        Guid $providerGuid,
        EventInterface $event
    )
    {
        $this->_providerGuid = $providerGuid;
        $this->_event = $event;
    }

    /**
     * @return EventInterface
     */
    public function getEvent()
    {
        return $this->_event;
    }

    /**
     * @return Guid
     */
    public function getProviderGuid()
    {
        return $this->_providerGuid;
    }
}