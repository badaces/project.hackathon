<?php

namespace App\Value;

class DataPoint
{
    /**
     * @var int
     */
    private $data;

    /**
     * @var int
     */
    private $month;

    /**
     * @var int
     */
    private $year;

    public function __construct($year, $month, $data)
    {
        $this->year = $year;
        $this->month = $month;
        $this->data = $data;
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
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }
}
