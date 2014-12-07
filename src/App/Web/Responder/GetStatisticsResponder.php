<?php

namespace App\Web\Responder;

use App\Entity\DataPoint;
use App\Entity\Mapper\DataPointMapper;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;
use Symfony\Component\HttpFoundation\Response;

class GetStatisticsResponder implements ResponderInterface
{
    /**
     * @var Collection|Selectable|DataPoint[]
     */
    private $dataPoints;

    /**
     * @var bool
     */
    private $hasError;

    /**
     * @param Collection|Selectable|DataPoint[] $dataPoints
     */
    public function setDataPoints($dataPoints)
    {
        $this->dataPoints = $dataPoints;
    }

    public function setHasError()
    {
        $this->hasError = true;
    }

    public function execute()
    {
        $returnData = [
            'result' => null,
            'error' => null
        ];

        $statusCode = Response::HTTP_OK;

        if (!$this->hasError) {
            $returnData['result'] = DataPointMapper::multipleToArray($this->dataPoints);
        } else {
            $statusCode = Response::HTTP_NOT_FOUND;
            $returnData['error'] = [
                'code' => $statusCode,
                'message' => 'Could not find statistics of the specified type'
            ];
        }

        return new Response(json_encode($returnData), $statusCode, [
            'Content-Type' => 'application/json'
        ]);
    }
}
