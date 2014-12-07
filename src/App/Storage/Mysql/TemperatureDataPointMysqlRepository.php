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

        $statement->query([
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
    }

    public function saveGroup($collection)
    {
        // @TODO: Finish this to prevent the database from being beaten up.
    }
}
