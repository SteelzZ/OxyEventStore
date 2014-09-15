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
     * @var String
     */
    private $_providerId;

    /**
     * @var EventInterface
     */
    private $_event;

    /**
     * Init
     *
     * @param String         $providerId
     * @param EventInterface $event
     *
     * @return StoreableEvent
     */
    public function __construct(
        $providerId,
        EventInterface $event
    )
    {
        $this->_providerId = $providerId;
        $this->_event      = $event;
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
    public function getProviderId()
    {
        return $this->_providerId;
    }
}