<?php

namespace App\Entity\Repository;

use App\Entity\DataPointType;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;

interface DataPointTypeRepository
{
    /**
     * @param int $id
     * @return DataPointType
     * @throws EntityNotFoundException
     */
    public function findById($id);

    /**
     * @param DataPointType $type
     * @throws StorageFailureException
     */
    public function save(DataPointType $type);
}
