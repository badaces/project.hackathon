<?php

namespace App\Entity\Mapper;

use App\Entity\TemperatureDataPoint;
use App\Value\Mapper\DataPointMapper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;

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
     * @param array $data
     * @return Collection|Selectable|TemperatureDataPoint[]
     */
    public static function multipleFromArray($data)
    {
        $collection = new ArrayCollection();

        foreach ($data as $dataItem) {
            $collection->add(self::fromArray($dataItem));
        }

        return $collection;
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
