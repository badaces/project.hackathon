<?php

namespace App\Web\Action;

use App\Entity\DataPointType;
use App\Entity\Repository\DataPointRepository;
use App\Entity\Repository\DataPointTypeRepository;
use App\Entity\Repository\Exception\EntityNotFoundException;
use App\Web\Responder\GetStatisticsResponder;
use Symfony\Component\HttpFoundation\Request;

class GetStatisticsAction implements ActionInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var GetStatisticsResponder
     */
    private $responder;

    /**
     * @var DataPointRepository
     */
    private $dataPointRepository;

    /**
     * @var DataPointTypeRepository
     */
    private $dataPointTypeRepository;

    public function __construct(
        Request $request,
        GetStatisticsResponder $responder,
        DataPointRepository $dataPointRepository,
        DataPointTypeRepository $dataPointTypeRepository
    )
    {
        $this->request = $request;
        $this->responder = $responder;
        $this->dataPointRepository = $dataPointRepository;
        $this->dataPointTypeRepository = $dataPointTypeRepository;
    }

    public function execute()
    {
        $responder = $this->responder;

        $queryParameters = $this->request->query;
        $typeName = $queryParameters->get('type');

        /** @var DataPointType $type */
        $type = null;
        try {
            $type = $this->dataPointTypeRepository->findByName($typeName);
        } catch (EntityNotFoundException $e) {
            $responder->setHasError();
            return $responder;
        }

        $dataPoints = $this->dataPointRepository->findByType($type);

        $responder->setDataPoints($dataPoints);

        return $responder;
    }
}
