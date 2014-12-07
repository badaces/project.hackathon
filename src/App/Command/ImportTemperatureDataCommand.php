<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportTemperatureDataCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('import:temperature_data')
            ->setDescription('Imports NASA GISTEMP temperature data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $formatter = $output->getFormatter();
//        $output->writeln('Heyoo!');

        var_dump($formatter);
    }
}
