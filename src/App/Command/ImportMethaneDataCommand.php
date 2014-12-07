<?php

namespace App\Command;

use App\Command\Exception\MissingFileException;
use App\Entity\DataPointType;
use App\Entity\Mapper\DataPointMapper;
use App\Entity\Mapper\DataPointTypeMapper;
use App\Entity\Repository\DataPointRepository;
use App\Entity\Repository\DataPointTypeRepository;
use App\Entity\Repository\Exception\EntityNotFoundException;
use CBC\Utility\Configuration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMethaneDataCommand extends Command
{
    /**
     * @var string
     */
    private $dataFilePath;

    /**
     * @var DataPointRepository
     */
    private $dataPointRepository;

    /**
     * @var DataPointTypeRepository
     */
    private $dataPointTypeRepository;

    public function __construct(
        Configuration $configuration,
        DataPointRepository $dataPointRepository,
        DataPointTypeRepository $dataPointTypeRepository
    )
    {
        $this->dataFilePath = $configuration->get('root_path') . '/app/data/ch4_mlo_surface-flask_1_ccgg_month.txt';
        $this->dataPointRepository = $dataPointRepository;
        $this->dataPointTypeRepository = $dataPointTypeRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('import:methane_data')
            ->setDescription('Imports ESRL GMD methane data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataPointTypeRepository = $this->dataPointTypeRepository;
        $dataPointRepository = $this->dataPointRepository;

        $dataPointType = null;
        try {
            $dataPointType = $dataPointTypeRepository->findByName(DataPointType::METHANE);
        } catch (EntityNotFoundException $e) {
            $dataPointType = new DataPointType(DataPointType::METHANE);
            $dataPointTypeRepository->save($dataPointType);
        }

        $dataPointType = DataPointTypeMapper::toArray($dataPointType);

        $data = $this->readDataFile($dataPointType);
        $dataPoints = DataPointMapper::multipleFromArray($data);

        $dataPointRepository->saveGroup($dataPoints);
    }

    private function readDataFile($type)
    {
        $filePath = $this->dataFilePath;

        if (!file_exists($filePath)) {
            throw new MissingFileException(sprintf('The file "%s" does not exist', $filePath));
        }

        $file = fopen($filePath, 'r');
        $data = [];

        while ($line = fgets($file, 128)) {
            if (ctype_alpha($line[0])) {
                $recordData = preg_split('/\s+/', $line);

                $data[] = [
                    'year' => (int)$recordData[1],
                    'month' => (int)$recordData[2],
                    'data' => (float)$recordData[3] / 1000, // Convert from PPB to PPM
                    'type' => $type
                ];
            }
        }

        fclose($file);

        return $data;
    }
}
