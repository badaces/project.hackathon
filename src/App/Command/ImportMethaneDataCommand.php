<?php

// Originally represented in parts per billion

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportMethaneDataCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('import:methane_data')
            ->setDescription('Imports ESRL GMD methane data')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        var_dump('herro!');
    }
}
