<?php
namespace Gslim\Console\Services\Creation;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gslim\Console\Helpers\MakeHelper;

class MakeController extends Command
{
    /**
     * set command name
     *
     * @var string
     */
    protected static $defaultName = 'make:controller';

    /**
     * set command description and add argument
     */
    protected function configure()
    {
        $this->setDescription('Create interface controller')
            ->addArgument(
                'classname',
                InputArgument::REQUIRED,
                'Path name/class name of the created interface controller file'
            );
    }

    /**
     * Create controller file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $className = MakeHelper::setClassName($input->getArgument('classname'), "Controller");
        
        try {
            list(
                $className,
                $path,
                $fileName
                ) = MakeHelper::generateFilePath(
                        $className,
                        'src/App' . DIRECTORY_SEPARATOR . 'Controllers'
                    );
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return 0;
        }
        // Controller
        $text = file_get_contents(__DIR__.'/Templates/controller.template.tpl');
        $generateRs  = file_put_contents(
            $fileName,
            preg_replace('/PregReplace/', "$className", $text)
        );

        if ($generateRs == true) {
            $output->writeln('<info>File generated</>');
        } else {
            $output->writeln('<error>File generation failed</>');
        }
        return 0;
    }
}
