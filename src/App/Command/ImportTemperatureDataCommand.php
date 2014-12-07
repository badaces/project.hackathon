<?php

namespace App\Command;

use App\Command\Exception\MissingFileException;
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

    public function __construct(Configuration $configuration)
    {
        $this->dataFilePath = $configuration->get('root_path') . '/app/data/GLB.Ts+dSST.txt';
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
        $data = $this->readDataFile();
        var_dump($data);
    }

    private function readDataFile()
    {
        $filePath = $this->dataFilePath;

        if (!file_exists($filePath)) {
            throw new MissingFileException(sprintf('The file "%s" does not exist', $filePath));
        }

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

                $data[] = $record;
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
