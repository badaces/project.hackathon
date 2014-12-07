<?php

namespace App\Entity\Repository;

use App\Entity\DataPoint;
use App\Entity\DataPointType;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;

interface DataPointRepository
{
    /**
     * @param $id
     * @return DataPoint
     * @throws EntityNotFoundException
     */
    public function findById($id);

    /**
     * @param DataPointType $type
     * @return Collection|Selectable|DataPoint[]
     */
    public function findByType(DataPointType $type);

    /**
     * @param DataPoint $temperatureDataPoint
     * @throws StorageFailureException
     */
    public function save(DataPoint $temperatureDataPoint);

    /**
     * @param Collection|DataPoint[] $collection
     * @throws StorageFailureException
     */
    public function saveGroup($collection);
}
