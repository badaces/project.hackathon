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

class ImportTemperatureDataCommand extends Command
{
    /**
     * @var string
     */
    private $dataFilePath;

    /**
     * @var DataPointTypeRepository
     */
    private $dataPointTypeRepository;

    /**
     * @var DataPointRepository
     */
    private $dataPointRepository;

    public function __construct(
        Configuration $configuration,
        DataPointTypeRepository $dataPointTypeRepository,
        DataPointRepository $dataPointRepository
    )
    {
        $this->dataFilePath = $configuration->get('root_path') . '/app/data/GLB.Ts+dSST.txt';
        $this->dataPointTypeRepository = $dataPointTypeRepository;
        $this->dataPointRepository = $dataPointRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('import:temperature_data')
            ->setDescription('Imports NASA GISTEMP temperature data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dataPointTypeRepository = $this->dataPointTypeRepository;
        $dataPointRepository = $this->dataPointRepository;

        $dataPointType = null;
        try {
            $dataPointTypeRepository->findByName(DataPointType::TEMPERATURE);

            $output->writeln('Data has already been imported.');
            return;
        } catch (EntityNotFoundException $e) {
            $dataPointType = new DataPointType(DataPointType::TEMPERATURE);
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

        $months = array_map(function ($month) {
            return strtolower(\DateTime::createFromFormat('!m', $month)->format('M'));
        }, range(1, 12));

        $file = fopen($this->dataFilePath, 'r');

        $headers = [];
        $data = [];

        while ($line = fgets($file, 128)) {
            // Process header names if we're on a header line.
            if (strpos($line, 'Year') === 0) {
                $headers = array_map('strtolower', preg_split('/\s+/', $line));
                array_pop($headers);
                array_pop($headers);
            }

            // Process record if we're on a record line.
            if (is_numeric($line[0])) {
                $recordData = preg_split('/\s+/', $line);
                array_pop($recordData);
                array_pop($recordData);

                $record = [];
                foreach ($headers as $key => $header) {
                    $record[$header] = (int)$recordData[$key];
                }

                foreach ($record as $key => $item) {
                    if (in_array($key, $months, true)) {
                        $data[] = [
                            'year' => $record['year'],
                            'month' => array_search($key, $months, true) + 1,
                            'data' => $item,
                            'type' => $type
                        ];
                    }
                }
            }

            // Stop processing once we hit a line containing only 7 spaces.
            if ($line === "       \n") {
                break;
            }
        }

        fclose($file);

        return $data;
    }
}
