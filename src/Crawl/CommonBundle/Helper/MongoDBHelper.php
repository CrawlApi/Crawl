<?php
/**
 * Created by PhpStorm.
 * User: marquis
 * Date: 16/3/15
 * Time: 下午2:29
 */

namespace Crawl\CommonBundle\Helper;

use Doctrine\DBAL\Exception\InvalidArgumentException;
use MongoDB\Driver\BulkWrite;
use \MongoDB\Driver\Manager as Manager;
use \MongoDB\Driver\Cursor as Cursor;
use \MongoDB\Driver\Query as Query;
use \MongoDB\Driver\Command as Command;

/**
 * Class MongoDBHelper
 * @package Crawl\CommonBundle\Helper
 */
class MongoDBHelper
{
    /**
     * @var Manager
     */
    public $mongodbManager;

    /**
     * @var
     */
    public $dbName;

    /**
     * MongoDBHelper constructor.
     * @param string $host
     * @param $dbName
     */
    function __construct($dbName, $host = 'localhost:27017')
    {
        $this->dbName = $dbName;
        $this->mongodbManager = new Manager('mongodb://' . $host);
    }

    /**
     * @param $collectionName
     * @param $filter
     * @return array|Cursor
     */
    public function find($collectionName, $filter)
    {
        $query = new Query($filter);
        $cursor = $this->mongodbManager->executeQuery("{$this->dbName}.{$collectionName}", $query);
        return $this->toArray($cursor);
    }

    /**
     * @param $collectionName
     * @param $filter
     * @return bool
     */
    public function findOne($collectionName, $filter)
    {
        $result = $this->find($collectionName, $filter);
        if (!empty($result)) return $result[0];
        else return FALSE;
    }

    /**
     * @param $collectionName
     * @param $document
     * @return bool|InvalidArgumentException
     */
    public function insert($collectionName, $document)
    {
        if (empty($document)) return new InvalidArgumentException("Document to be inserted is empty.");
        $bulkWrite = new BulkWrite(["ordered" => TRUE]);
        $bulkWrite->insert($document);
        $result = $this->mongodbManager->executeBulkWrite("{$this->dbName}.{$collectionName}", $bulkWrite);
        return (bool)$result->getInsertedCount();
    }

    /**
     * @param $collectionName
     * @param $filter
     * @param $document
     * @param $updateOptions
     * @return bool|InvalidArgumentException
     */
    public function update($collectionName, $filter, $document, $updateOptions)
    {
        if (empty($filter)) return new InvalidArgumentException("The filter is empty. You probably don't want to update every document.");
        if (empty($document)) return new InvalidArgumentException("The edit document is empty");
        $bulkWrite = new BulkWrite(["ordered" => TRUE]);
        $bulkWrite->update($filter, $document, $updateOptions);
        $result = $this->mongodbManager->executeBulkWrite("{$this->dbName}.{$collectionName}", $bulkWrite);
        return (bool)$result->getModifiedCount();
    }


    /**
     * @param $collectionName
     * @param $pipeline
     * @return InvalidArgumentException
     */
    public function aggregate($collectionName, $pipeline)
    {
        if (empty($pipeline)) return new InvalidArgumentException("The pipeline is empty.");
        $commandArray = [
            'aggregate' => $collectionName,
            'pipeline' => $pipeline,
        ];
        $command = new Command($commandArray);
        $cursor = $this->mongodbManager->executeCommand($this->dbName, $command);
        return $this->toArray($cursor)[0]->result;
    }

    /**
     * @param Cursor $cursor
     * @return array|Cursor
     */
    public static function toArray(Cursor $cursor)
    {
        if (is_object($cursor) && get_class($cursor) == 'MongoDB\Driver\Cursor') {
            $cursor = iterator_to_array($cursor);
        } else if (is_array($cursor)) {
            if (isset($cursor['n'])) unset($cursor['n']);
            if (isset($cursor['err'])) unset($cursor['err']);
            if (isset($cursor['errmsg'])) unset($cursor['errmsg']);
        }
        return $cursor;
    }
}