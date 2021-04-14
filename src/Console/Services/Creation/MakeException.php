<?php
namespace Gslim\Console\Services\Creation;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gslim\Console\Helpers\MakeHelper;

class MakeException extends Command
{
    /**
     * Set command service name
     *
     * @var string
     */
    protected static $defaultName = 'make:exception';

    /**
     * Set command description
     *
     */
    protected function configure()
    {
        $this->setDescription('Create service interface')
            ->addArgument(
                'classname',
                InputArgument::REQUIRED,
                'Path name/class name of the created service interface file'
            );
    }

    /**
     * Create service file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $className = MakeHelper::setClassName($input->getArgument('classname'), "Exception");

        try {
            list(
                $className,
                $path,
                $fileName
                ) = MakeHelper::generateFilePath(
                    $className,
                    'src/App' . DIRECTORY_SEPARATOR . 'Exceptions'
                );
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return 0;
        }

        // service
        $text = file_get_contents(__DIR__.'/Templates/exeptions.template.tpl');
        $generateRs  = file_put_contents(
            $fileName,
            preg_replace('/PregReplace/', $className, $text)
        );

        if ($generateRs == true) {
            $output->writeln('<info>File generated</>');
        } else {
            $output->writeln('<error>File generation failed</>');
        }
        return 0;
    }

}
