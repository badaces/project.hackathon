<?php

namespace App\Value\Mapper;

use App\Value\DataPoint;

class DataPointMapper
{
    /**
     * @param array $data
     * @return DataPoint
     */
    public static function fromArray($data)
    {
        return new DataPoint(
            (int)$data['year'],
            (int)$data['month'],
            (int)$data['data']
        );
    }

    /**
     * @param DataPoint $dataPoint
     * @return array
     */
    public static function toArray(DataPoint $dataPoint)
    {
        return [
            'year' => $dataPoint->getYear(),
            'month' => $dataPoint->getMonth(),
            'data' => $dataPoint->getData()
        ];
    }
}
