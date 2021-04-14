<?php
namespace Gslim\Console\Services\Creation;

use Gslim\Console\Helpers\MakeHelper;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeCommand extends Command
{
    /**
     * set command name
     *
     * @var string
     */
    protected static $defaultName = 'make:command';

    /**
     * set command description and add argument
     */
    protected function configure()
    {
        $this->setDescription('Create command file')
            ->addArgument(
                'classname', 
                InputArgument::REQUIRED, 
                'Path name/class name of the command file created'
            );
    }

    /**
     * Create Command file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $className = MakeHelper::setClassName($input->getArgument('classname'), "Command");
        $commands = MakeHelper::getReplacement($input->getArgument('classname'));  

        try {
            list(
                $className, 
                $path, 
                $fileName) = MakeHelper::generateFilePath(
                    $className, 
                    'src/Console' . DIRECTORY_SEPARATOR . 'Command'
                );
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return 0;
        }

        $patterns = ['/PregReplace/',  '/ReplaceCustomize/', '/ReplaceCommand/' ] ;    
        $replacements = [$className, $commands[0], $commands[1]];
        
        $text = file_get_contents(__DIR__.'/templates/command.template.tpl');
        $generated = file_put_contents(
            $fileName,
            preg_replace($patterns, $replacements, $text)
        );
        
        if ($generated == true) {
            $output->writeln('<info>File generated</>');
        } else {
            $output->writeln('<error>File generation failed</>');
        }

        return 0;
    }

}
