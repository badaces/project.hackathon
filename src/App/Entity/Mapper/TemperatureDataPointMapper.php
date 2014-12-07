<?php

namespace App\Entity\Mapper;

use App\Entity\TemperatureDataPoint;
use App\Value\Mapper\DataPointMapper;

class TemperatureDataPointMapper
{
    /**
     * @param array $data
     * @return TemperatureDataPoint
     */
    public static function fromArray($data)
    {
        $id = null;

        if (array_key_exists('id', $data)) {
            $id = (int)$data['id'];
        }

        $dataPoint = DataPointMapper::fromArray($data);

        return new TemperatureDataPoint($dataPoint, $id);
    }

    /**
     * @param TemperatureDataPoint $temperatureDataPoint
     * @return array
     */
    public static function toArray(TemperatureDataPoint $temperatureDataPoint)
    {
        return [
            'dataPoint' => DataPointMapper::toArray($temperatureDataPoint->getDataPoint()),
            'id' => $temperatureDataPoint->getId()
        ];
    }
}
