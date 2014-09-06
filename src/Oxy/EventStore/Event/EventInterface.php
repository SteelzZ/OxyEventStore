<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Event;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getEventName();
}