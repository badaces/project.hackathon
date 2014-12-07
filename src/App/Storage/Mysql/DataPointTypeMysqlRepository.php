<?php

namespace App\Storage\Mysql;

use App\Entity\DataPointType;
use App\Entity\Mapper\DataPointTypeMapper;
use App\Entity\Repository\DataPointTypeRepository;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;

class DataPointTypeMysqlRepository implements DataPointTypeRepository
{
    /**
     * @var \PDO
     */
    private $database;

    /**
     * @var string
     */
    private $tableName = 'data_point_type';

    public function __construct(\PDO $database)
    {
        $this->database = $database;
    }

    public function findById($id)
    {
        $database = $this->database;

        $sql  = 'SELECT id, name';
        $sql .= ' FROM ' . $this->tableName;
        $sql .= ' WHERE id = :id';

        $statement = $database->prepare($sql);

        $statement->execute([
            ':id' => $id
        ]);

        if ($statement->rowCount() === 0) {
            throw new EntityNotFoundException(sprintf(
                'Could not find DataPointType entity by ID %s',
                $id
            ));
        }

        return DataPointTypeMapper::fromArray($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function findByName($name)
    {
        $database = $this->database;

        $sql  = 'SELECT id, name';
        $sql .= ' FROM ' . $this->tableName;
        $sql .= ' WHERE name = :name';

        $statement = $database->prepare($sql);

        $statement->execute([
            ':name' => strtolower($name)
        ]);

        if ($statement->rowCount() === 0) {
            throw new EntityNotFoundException(sprintf(
                'Could not find DataPointType entity by name %s',
                $name
            ));
        }

        return DataPointTypeMapper::fromArray($statement->fetch(\PDO::FETCH_ASSOC));
    }

    public function save(DataPointType $type)
    {
        $database = $this->database;

        $sql  = 'INSERT INTO ' . $this->tableName;
        $sql .= '(name)';
        $sql .= ' VALUES(:name)';

        $statement = $database->prepare($sql);

        $result = $statement->execute([
            ':name' => $type->getName()
        ]);

        if (!$result) {
            throw new StorageFailureException('Could not save DataPointType');
        }

        $type->setId((int)$database->lastInsertId());
    }
}
