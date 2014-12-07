<?php

namespace App\Command;

use CBC\Utility\Configuration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTemperatureDataCommand extends Command
{
    /**
     * @var string
     */
    private $dataUrl;

    public function __construct(Configuration $configuration)
    {
        $this->dataUrl = $configuration->get('data.giis.url');
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
        var_dump($this->dataUrl);
    }
}
