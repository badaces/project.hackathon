<?php

namespace App\Entity;

class DataPoint
{
    /**
     * @var int
     */
    private $data;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $month;

    /**
     * @var DataPointType
     */
    private $type;

    /**
     * @var int
     */
    private $year;

    public function __construct($year, $month, $data, DataPointType $type, $id = null)
    {
        $this->year = $year;
        $this->month = $month;
        $this->data = $data;
        $this->type = $type;
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return DataPointType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
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
