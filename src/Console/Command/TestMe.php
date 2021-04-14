<?php
namespace Gslim\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestMe extends Command
{
    protected static $defaultName = 'Test:Me';

    protected function configure()
    {
        $this->setDescription('Command description');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {


        return 0;
    }
}
