<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Event;

use Oxy\Core\Collection\CollectionInterface;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
interface StoreableEventsCollectionInterface extends CollectionInterface
{
    /**
     * Set collection items
     *
     * @param array $collectionItems
     */
    public function addEvents(array $collectionItems);

    /**
     * Store event
     *
     * @param StoreableEventInterface $event
     *
     * @return void
     */
    public function addEvent(StoreableEventInterface $event);
}