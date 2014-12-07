<?php

namespace App\Entity\Mapper;

use App\Entity\DataPointType;

class DataPointTypeMapper
{
    /**
     * @param array $data
     * @return DataPointType
     */
    public static function fromArray($data)
    {
        $id = null;

        if (array_key_exists('id', $data)) {
            $id = (int)$data['id'];
        }

        return new DataPointType($data['name'], $id);
    }

    /**
     * @param DataPointType $type
     * @return array
     */
    public static function toArray(DataPointType $type)
    {
        return [
            'id' => $type->getId(),
            'name' => $type->getName()
        ];
    }
}
