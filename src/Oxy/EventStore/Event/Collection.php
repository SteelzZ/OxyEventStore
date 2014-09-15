<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\Event;

use Oxy\Core\Collection as OxyCoreCollection;

/**
 * @category Oxy
 * @package  Oxy\EventStore\Event
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 **/
class Collection extends OxyCoreCollection
{
    /**
     * @param array $collectionItems
     */
    public function __construct(array $collectionItems = array())
    {
        parent::__construct('Oxy\EventStore\Event\EventInterface', $collectionItems);
    }
}