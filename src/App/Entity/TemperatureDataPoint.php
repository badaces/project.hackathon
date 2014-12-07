<?php

namespace App\Entity;

use App\Value\DataPoint;

class TemperatureDataPoint
{
    /**
     * @var DataPoint
     */
    private $dataPoint;

    /**
     * @var int
     */
    private $id;

    public function __construct(DataPoint $dataPoint, $id = null)
    {
        $this->dataPoint = $dataPoint;
        $this->id = $id;
    }

    /**
     * @return DataPoint
     */
    public function getDataPoint()
    {
        return $this->dataPoint;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
