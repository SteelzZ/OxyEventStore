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
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
abstract class ArrayableAbstract implements ArrayableInterface
{   
    const EVENT_NAME_PROPERTY = '_eventName';
    
    /**
     * Event name
     * 
     * @var string
     */ 
    protected $_eventName;

    /**
     * Initialize event
     *
     * @param array $eventData
     *
     * @throws Exception
     */
    public function __construct(array $eventData = array())
    {
        $foundEventNameProperty = false;
        foreach($eventData as $key => $value){
            if(is_string($value) || is_int($value) || is_bool($value) || is_array($value) || is_null($value)){
                $key = '_' . trim($key, '_');
                
                if(($key === self::EVENT_NAME_PROPERTY) && !empty($value)){
                    $foundEventNameProperty = true;
                }
                
                $this->$key = $value;
            } else {
                throw new Exception(
                    sprintf(
                    	'Event can contain only basic type data int, string, bool this - {%s}-{%s} is not basic type!', 
                        $key, 
                        $value
                    )
                ); 
            }
        }
        
        if(!$foundEventNameProperty){
            $propertyName = self::EVENT_NAME_PROPERTY;
            $className = get_class($this);
            $eventName = array_pop(explode('_', $className));
            $this->$propertyName = $eventName;
        }
    }

    /**
     * Safety check
     *
     * @param string $property
     * @param string $value
     *
     * @throws Exception
     */
    public function __set($property, $value)
    {
        throw new Exception(
            sprintf(
            	'You have passed property {%s} that is not defined! Event class [%s]', 
                $property,
                get_class($this)
            )
        );
    }
    
    /**
     * Convert event to array
     * 
     * @return array
     */
    public function toArray()
    {
        $properties = get_class_vars(get_class($this));
        $vars = array();
        foreach ($properties as $name => $defaultVal) {
            $vars[$name] = $this->$name; 
        }  

        return $vars;
    }
    
    /**
     * @return string
     */
    public function getEventName()
    {
        return $this->_eventName;
    }
}