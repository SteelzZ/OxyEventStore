<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\EventHandler
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\EventHandler;

use Oxy\EventStore\Event\EventInterface;

/**
 * Event handler interface
 *
 * @category Oxy
 * @package  Oxy\EventStore\EventHandler
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface EventHandlerInterface
{
    /**
     * Handle event
     *
     * @param EventInterface $event
     *
     * @return void
     */
    public function handle(EventInterface $event);
}