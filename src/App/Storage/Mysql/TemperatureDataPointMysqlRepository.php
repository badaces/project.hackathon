<?php

namespace App\Storage\Mysql;

use App\Entity\Mapper\TemperatureDataPointMapper;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;
use App\Entity\Repository\TemperatureDataPointRepository;
use App\Entity\TemperatureDataPoint;

class TemperatureDataPointMysqlRepository implements TemperatureDataPointRepository
{
    /**
     * @var \PDO
     */
    private $database;

    /**
     * @var string
     */
    private $tableName = 'temperature_data_point';

    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function findById($id)
    {
        $database = $this->database;

        $sql  = 'SELECT id, year, month, data';
        $sql .= ' FROM ' . $this->tableName;
        $sql .= ' WHERE id = :id';

        $statement = $database->prepare($sql);

        $statement->execute([
            ':id' => $id
        ]);

        if ($statement->rowCount() === 0) {
            throw new EntityNotFoundException(sprintf(
                'Could not find TemperatureDataPoint entity by ID %s',
                $id
            ));
        }

        return TemperatureDataPointMapper::fromArray($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function findAll()
    {
        $database = $this->database;

        $sql  = 'SELECT id, year, month, data';
        $sql .= ' FROM ' . $this->tableName;

        $statement = $database->query($sql);

        return TemperatureDataPointMapper::multipleFromArray($statement->fetchAll(\PDO::FETCH_ASSOC));
    }

    public function save(TemperatureDataPoint $temperatureDataPoint)
    {
        $data = TemperatureDataPointMapper::toArray($temperatureDataPoint);
        $dataPoint = $data['dataPoint'];
        $database = $this->database;

        $sql  = 'INSERT INTO ' . $this->tableName;
        $sql .= '(year, month, data)';
        $sql .= ' VALUES(:year, :month, :data)';

        $statement = $database->prepare($sql);

        $result = $statement->execute([
            ':year' => $dataPoint['year'],
            ':month' => $dataPoint['month'],
            ':data' => $dataPoint['data']
        ]);

        if (!$result) {
            throw new StorageFailureException('Could not save TemperatureDataPoint');
        }

        $temperatureDataPoint->setId((int)$database->lastInsertId());
    }

    public function saveGroup($collection)
    {
        $batchSize = 500;

        $database = $this->database;

        $sql  = 'INSERT INTO ' . $this->tableName;
        $sql .= ' (year, month, data)';
        $sql .= ' VALUES';

        $newSql = $sql;
        $params = [];

        $database->beginTransaction();
        foreach ($collection as $index => $temperatureDataPoint) {
            $newSql .= '(?, ?, ?),';
            $dataPoint = $temperatureDataPoint->getDataPoint();
            $params = array_merge($params, [
                $dataPoint->getYear(),
                $dataPoint->getMonth(),
                $dataPoint->getData()
            ]);

            if ($index > 0 && $index % $batchSize === 0) {
                $newSql = substr($newSql, 0, -1);
                $statement = $database->prepare($newSql);
                $result = $statement->execute($params);

                $newSql = $sql;
                $params = [];

                if (!$result) {
                    throw new StorageFailureException('Could not save TemperatureDataPoint collection');
                }
            }
        }

        // If there are bound params, then there are still pending inserts that did not fill a full batch
        if ($params) {
            $newSql = substr($newSql, 0, -1);
            $statement = $database->prepare($newSql);
            $result = $statement->execute($params);

            if (!$result) {
                throw new StorageFailureException('Could not save TemperatureDataPoint collection');
            }
        }

        $result = $database->commit();

        if (!$result) {
            throw new StorageFailureException('Could not save TemperatureDataPoint collection');
        }
    }
}
