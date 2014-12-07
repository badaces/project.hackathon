<?php

namespace App\Entity\Repository;

use App\Entity\DataPoint;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;
use Doctrine\Common\Collections\Collection;

interface DataPointRepository
{
    /**
     * @param $id
     * @return DataPoint
     * @throws EntityNotFoundException
     */
    public function findById($id);

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
