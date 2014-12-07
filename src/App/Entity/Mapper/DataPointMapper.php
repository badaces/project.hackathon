<?php

namespace App\Entity\Mapper;

use App\Entity\DataPoint;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;

class DataPointMapper
{
    /**
     * @param array $data
     * @return DataPoint
     */
    public static function fromArray($data)
    {
        $id = null;

        if (array_key_exists('id', $data)) {
            $id = (int)$data['id'];
        }

        $type = DataPointTypeMapper::fromArray($data['type']);

        return new DataPoint(
            (int)$data['year'],
            (int)$data['month'],
            (int)$data['data'],
            $type,
            $id
        );
    }

    /**
     * @param array $data
     * @return Collection|Selectable|DataPoint[]
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
     * @param DataPoint $dataPoint
     * @return array
     */
    public static function toArray(DataPoint $dataPoint)
    {
        return [
            'data' => $dataPoint->getData(),
            'id' => $dataPoint->getId(),
            'month' => $dataPoint->getMonth(),
            'type' => DataPointTypeMapper::toArray($dataPoint->getType()),
            'year' => $dataPoint->getYear()
        ];
    }
}
