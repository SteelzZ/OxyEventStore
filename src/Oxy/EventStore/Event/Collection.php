<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Event;

use Oxy\Core\Collection;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 **/
class Oxy_EventStore_Event_Collection extends Collection
{
    /**
     * @param array $collectionItems
     */
    public function __construct(array $collectionItems = array())
    {
        parent::__construct('Oxy\EventStore\Event\EventInterface', $collectionItems);
    }
}