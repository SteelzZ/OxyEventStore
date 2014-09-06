<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Event;

/**
 * Domain arrayable event interface
 * Load and convert event to array
 *
 * @category Oxy
 * @package Oxy_Domain
 * @subpackage Event
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
interface ArrayableInterface extends EventInterface
{    
    /**
     * Convert event to array
     * 
     * @return array
     */
    public function toArray();
}