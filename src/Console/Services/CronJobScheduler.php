<?php
namespace Gslim\Console\Services;

use Cron\CronExpression;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Output\OutputInterface;

class CronJobScheduler extends Command
{
    protected static $defaultName = 'schedule:run';

    private $command;

    protected function configure()
    {
        $this->setDescription('Run timed task scheduling commands');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // DEMO
        $this->command('test:run')->expression('@hourly');

        return 0;
    }

    private function command(string $command): CronJobScheduler
    {
        $isExist = $this->getApplication()->has($command);
        if ($isExist === true) {
            $this->command = $command;
        } else {
            $this->command = '';
        }
        return $this;
    }

    private function expression(string $expression): bool
    {
        if ($this->command == '') {
            return false;
        }
        if (!CronExpression::isValidExpression($expression)) {
            return false;
        }

        $cron = CronExpression::factory($expression);
        $nextTime = $cron->getNextRunDate()->getTimestamp();
        $nowTime = time();
        if ($nextTime <= $nowTime) {
            return false;
        }
        if (($nextTime - $nowTime) > 60) {
            return false;
        }

        $this->doRun();

        return true;
    }

    private function doRun()
    {
        $command = $this->getApplication()->find($this->command);
        $command->run(new ArgvInput(), new NullOutput());
    }
}
