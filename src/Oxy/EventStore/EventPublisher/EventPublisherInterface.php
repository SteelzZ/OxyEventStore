<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\EventPublisher
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\EventPublisher;

use Oxy\EventStore\Event\StoreableEventsCollectionInterface;

/**
 * Events publisher interface
 *
 * @category Oxy
 * @package  Oxy\EventStore\EventPublisher
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface EventPublisherInterface
{
    /**
     * Notify listeners about events
     *
     * @param StoreableEventsCollectionInterface $events
     *
     * @return void
     */
    public function notifyListeners(StoreableEventsCollectionInterface $events);
}