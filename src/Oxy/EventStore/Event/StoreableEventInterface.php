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
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
interface StoreableEventInterface
{
    /**
     * @return EventInterface
     */
    public function getEvent();
    
    /**
     * @return Guid
     */
    public function getProviderGuid();
}