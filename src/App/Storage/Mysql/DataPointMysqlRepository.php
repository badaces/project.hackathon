<?php

namespace App\Storage\Mysql;

use App\Entity\DataPoint;
use App\Entity\DataPointType;
use App\Entity\Mapper\DataPointMapper;
use App\Entity\Repository\DataPointRepository;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;

class DataPointMysqlRepository implements DataPointRepository
{
    /**
     * @var \PDO
     */
    private $database;

    /**
     * @var string
     */
    private $tableName = 'data_point';

    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function findById($id)
    {
        $database = $this->database;

        $sql  = 'SELECT d.id, d.year, d.month, d.data, t.id as tid, t.name as tname';
        $sql .= ' FROM ' . $this->tableName . ' d';
        $sql .= ' LEFT JOIN data_point_type t ON d.type = t.id';
        $sql .= ' WHERE d.id = :id';

        $statement = $database->prepare($sql);

        $statement->execute([
            ':id' => $id
        ]);

        if ($statement->rowCount() === 0) {
            throw new EntityNotFoundException(sprintf(
                'Could not find DataPoint entity by ID %s',
                $id
            ));
        }

        $record = $statement->fetch(\PDO::FETCH_ASSOC);
        $record['type'] = [
            'id' => $record['tid'],
            'name' => $record['tname']
        ];

        return DataPointMapper::fromArray($record);
    }

    public function findByType(DataPointType $type)
    {
        $database = $this->database;

        $sql  = 'SELECT d.id, d.year, d.month, d.data, t.id as tid, t.name as tname';
        $sql .= ' FROM ' . $this->tableName . ' d';
        $sql .= ' LEFT JOIN data_point_type t ON d.type = t.id';
        $sql .= ' WHERE d.type = :type';

        $statement = $database->prepare($sql);

        $statement->execute([
            ':type' => $type->getId()
        ]);

        if ($statement->rowCount() === 0) {
            throw new EntityNotFoundException(sprintf(
                'Could not find DataPoint entity by type "%s"',
                $type->getName()
            ));
        }

        $records = $statement->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($records as &$record) {
            $record['type'] = [
                'id' => $record['tid'],
                'name' => $record['tname']
            ];
        }

        return DataPointMapper::multipleFromArray($records);
    }

    public function save(DataPoint $dataPoint)
    {
        $database = $this->database;

        $sql  = 'INSERT INTO ' . $this->tableName;
        $sql .= '(year, month, data, type)';
        $sql .= ' VALUES(:year, :month, :data, :type)';

        $statement = $database->prepare($sql);

        $result = $statement->execute([
            ':year' => $dataPoint->getYear(),
            ':month' => $dataPoint->getMonth(),
            ':data' => $dataPoint->getData(),
            ':type' => $dataPoint->getType()->getId()
        ]);

        if (!$result) {
            throw new StorageFailureException('Could not save DataPoint');
        }

        $dataPoint->setId((int)$database->lastInsertId());
    }

    public function saveGroup($collection)
    {
        $batchSize = 500;

        $database = $this->database;

        $sql  = 'INSERT INTO ' . $this->tableName;
        $sql .= ' (year, month, data, type)';
        $sql .= ' VALUES';

        $newSql = $sql;
        $params = [];

        $database->beginTransaction();
        foreach ($collection as $index => $dataPoint) {
            $newSql .= '(?, ?, ?, ?),';
            $params = array_merge($params, [
                $dataPoint->getYear(),
                $dataPoint->getMonth(),
                $dataPoint->getData(),
                $dataPoint->getType()->getId()
            ]);

            if ($index > 0 && $index % $batchSize === 0) {
                $newSql = substr($newSql, 0, -1);
                $statement = $database->prepare($newSql);
                $result = $statement->execute($params);

                $newSql = $sql;
                $params = [];

                if (!$result) {
                    throw new StorageFailureException('Could not save DataPoint collection');
                }
            }
        }

        // If there are bound params, then there are still pending inserts that did not fill a full batch
        if ($params) {
            $newSql = substr($newSql, 0, -1);
            $statement = $database->prepare($newSql);
            $result = $statement->execute($params);

            if (!$result) {
                throw new StorageFailureException('Could not save DataPoint collection');
            }
        }

        $result = $database->commit();

        if (!$result) {
            throw new StorageFailureException('Could not save DataPoint collection');
        }
    }
}
