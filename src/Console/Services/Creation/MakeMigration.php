<?php
namespace Gslim\Console\Services\Creation;

use Exception;
use Gslim\Console\Helpers\MigrationHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Gslim\Console\Helpers\MakeHelper;

class MakeMigration extends Command
{
    /**
     * Set command name
     *
     * @var string
     */
    protected static $defaultName = 'make:migration';

    /**
     * Set Command Description & add Argument output
     */
    protected function configure()
    {
        $this->setDescription('Create database migration file e. g. create_user_access_table / update_user_access_table')
            ->addArgument('tablename', InputArgument::REQUIRED, 'The name of the database table created');
    }

    /**
     * Create Migration file
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $tablename = $input->getArgument('tablename');

        // Check for illegal characters in table name parameters
        $tablename = strtolower($tablename);
        $allowedCharacters = 'abcdefghijklmnopqrstuvwxyz0123456789_';
        $allowedCharacters = str_split($allowedCharacters);

        $tablename = array_map(function ($v) use ($allowedCharacters) {
            if (!in_array($v, $allowedCharacters)) {
                throw new Exception('Characters in table name【' . $v . '】Is an illegal character');
            }
            return $v;
        }, str_split($tablename));

        $tablename = implode('', $tablename);
        unset($allowedCharacters);

        $isCreate = $this->isCreateTable($tablename);

        $className = array_map(function ($v) {
            return ucfirst($v);
        }, explode('_', $tablename));

        $className = implode('', $className);
        $fileName = MigrationHelper::tablenameConvertFilename($tablename);


        $tablenameTmp =  explode("_",$tablename);
        $tablename = $tablenameTmp[1]."_".$tablenameTmp[2];
        //replacement
        $patterns = ['/PregReplace/',  '/Tablename/' ] ;
        $replacements = [$className, $tablename];
        $mingrations = $isCreate === true ? "migrationtable" :  "migrationupdatetable" ;
        $text = file_get_contents(__DIR__."/Templates/{$mingrations}.template.tpl");
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

    /**
     * Whether to add a data sheet
     *
     * @param string $tableName table name
     * @return bool
     */
    private function isCreateTable(string $tableName): bool
    {
        $prefix = substr($tableName, 0, 7);
        $suffix = substr($tableName, -6);

        if ($prefix == 'create_' && $suffix == '_table') {
            return true;
        } else {
            return false;
        }
    }
}
