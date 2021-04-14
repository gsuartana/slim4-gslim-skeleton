<?php
namespace Gslim\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelpCommand extends Command
{
    protected static $defaultName = 'Help:Command';

    protected function configure()
    {
        $this->setDescription('Command description');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

        echo "I am help...\n";
        return 0;
    }
}
