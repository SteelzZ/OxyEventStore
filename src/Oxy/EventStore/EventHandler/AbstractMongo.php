<?php
/**
 * @category Oxy
 * @package  Oxy\EventStore\EventHandler
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */

namespace Oxy\EventStore\EventHandler;

/**
 * @category Oxy
 * @package  Oxy\EventStore\EventHandler
 * @author   Tomas Bartkus <to.bartkus@gmail.com>
 */
abstract class AbstractMongo
{
    /**
     * Database adapter
     *
     * @var \MongoClient
     */
    protected $_db;

    /**
     * Database name
     *
     * @var String
     */
    protected $_dbName;

    /**
     * @param \MongoClient $db
     * @param string $dbName
     */
    public function __construct(\MongoClient $db, $dbName)
    {
        $this->_db = $db->selectDB($dbName);
        $this->_dbName = $dbName;
    }
    
    /**
     * @param array $data
     * @param string $collection
     */
    protected function _insertData($data, $collection)
    {
        $collection = $this->_db->selectCollection($collection);
        $collection->insert($data, array("safe" => true));
    }
}