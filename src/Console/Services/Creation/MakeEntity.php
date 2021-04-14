<?php

namespace Gslim\Console\Services\Creation;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gslim\Console\Helpers\MakeHelper;
use Exception;

class MakeEntity extends Command
{

    /**
     * set command name
     *
     * @var string
     */
    protected function configure()
    {
        $this->setName('make:entity');
        $this->addArgument("classname", InputArgument::REQUIRED, 'Path name/class name of the Entity file created');
        $this->setDescription('Create Entity e. g. UserAccess = tablename user_access');
    }

    /**
     * Create Entity File
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $className = $input->getArgument('classname');
        $classNameRepository = $input->getArgument('classname')."Repository";

        try {
            list(
                $className, 
                $path, 
                $fileName) = MakeHelper::generateFilePath(
                    $className, 'src/App' . DIRECTORY_SEPARATOR . 'Entity'
                );
            list(
                $classNameRepository,
                 $path, 
                 $fileNameRepository) = MakeHelper::generateFilePath(
                     $classNameRepository, 'src/App' . DIRECTORY_SEPARATOR . 'Repository'
                );
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return 0;
        }

        $patterns = ['/PregReplace/',  '/Tablename/' ] ;
        $tableName = strtolower(preg_replace('/(.)([A-Z])/', '$1_$2', $className));
        $replacements = [$className, $tableName];

        // Entity
        $text = file_get_contents(__DIR__.'/Templates/entity.template.tpl');
        file_put_contents(
            $fileName,
            preg_replace($patterns, $replacements, $text)
        );
        // Repository
        $text = file_get_contents(__DIR__.'/Templates/repository.template.tpl');
        $generated = file_put_contents(
            $fileNameRepository,
            preg_replace('/PregReplace/', "$classNameRepository", $text)
        );

        if ($generated == true) {
            $output->writeln('<info>File generated</>');
        } else {
            $output->writeln('<error>File generation failed</>');
        }
        return 0;
    }
}
