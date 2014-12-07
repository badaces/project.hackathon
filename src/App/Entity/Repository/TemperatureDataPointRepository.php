<?php

namespace App\Entity\Repository;

use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Entity\Repository\Exception\StorageFailureException;
use App\Entity\TemperatureDataPoint;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;

interface TemperatureDataPointRepository
{
    /**
     * @param $id
     * @return TemperatureDataPoint
     * @throws EntityNotFoundException
     */
    public function findById($id);

    /**
     * @return Collection|Selectable|TemperatureDataPoint[]
     */
    public function findAll();

    /**
     * @param TemperatureDataPoint $temperatureDataPoint
     * @throws StorageFailureException
     */
    public function save(TemperatureDataPoint $temperatureDataPoint);

    /**
     * @param Collection|TemperatureDataPoint[] $collection
     * @throws StorageFailureException
     */
    public function saveGroup($collection);
}
