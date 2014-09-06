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
 * @package Oxy_Domain
 * @subpackage Event
 * @author Tomas Bartkus <to.bartkus@gmail.com>
 */
class StoreableEventsCollection extends Collection implements StoreableEventsCollectionInterface
{
    /**
     * @param array $collectionItems
     */
    public function __construct(array $collectionItems = array())
    {
        parent::__construct('Oxy\EventStore\Event\StoreableEventInterface');
        $this->addEvents($collectionItems);
    }
    
	/**
     * Add collection items
     *
     * @param array $collectionItems
     */
    public function addEvents(array $collectionItems)
    {
        if (!empty($collectionItems)) {
            foreach ($collectionItems as $event) {
                $this->addEvent($event);
            }
        }
    }
    
    /**
     * Add a value into the collection
     * 
     * @param StoreableEventInterface $event

     * @throws \InvalidArgumentException when wrong type
     *
     * @return void
     */
    public function addEvent(StoreableEventInterface $event)
    {
        if (!$this->isValidType($event)) {
            $currentType = get_class($event);
            throw new \InvalidArgumentException(
                "Trying to add a value of wrong type {$this->_valueType} {$currentType}"
            );
        }

        $this->_collection[] = $event;
    }
    
	/**
     * Convert collection to array
     * 
     * @return array
     */
    public function toArray()
    {
        if ($this->_isBasicType) {
            return $this->_collection;
        } else {
            $collectionArray = array();
            foreach ($this->_collection as $key => $element){
                // If this is collection of non-basic elements,
                // check if that element knows how to convert itself into array
                if (method_exists($element, 'toArray')){
                    $collectionArray[$key] = $element->toArray();
                } else {
                    foreach ($element as $childKey => $childElement){
                        $collectionArray[$key][$childKey] = $childElement;
                    }
                }
            }

            return $collectionArray;
        }
    }
}