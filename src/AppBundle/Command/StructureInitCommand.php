<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;

class StructureInitCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('structure:init')
            ->setDescription('Initializes the project.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commandSend1 = $this->getApplication()->find('avanzu:admin:initialize');
        $commandSend1->run($input, $output);

        $commandSend2 = $this->getApplication()->find('assets:install');
        $commandSend2->run($input, $output);

        $commandSend3 = $this->getApplication()->find('doctrine:database:create');
        $commandSend3->run($input, $output);

        $commandSend4 = $this->getApplication()->find('doctrine:schema:update');
        $arguments4 =[
            'command' => 'doctrine:schema:update',
            '--force' => true,
        ];
        $input4 = new ArrayInput($arguments4);
        $commandSend4->run($input4, $output);

        $commandSend5 = $this->getApplication()->find('doctrine:database:import');
        $arguments5 =[
            'command' => 'doctrine:database:import',
            'file' => 'sql/begin_data.sql',
        ];
        $input5 =new ArrayInput($arguments5);
        $commandSend5->run($input5, $output);

        $output->writeln([
            'The process has been completed successfully.',
            '--------------------------------------------',
            'Login with the following account administrator:',
            ' ',
            'User: admin~',
            'Pass: admin',
        ]);
    }

}
