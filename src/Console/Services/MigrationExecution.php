<?php
namespace Gslim\Console\Services;

use Exception;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Gslim\Console\Helpers\MigrationHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationExecution extends Command
{
    protected static $defaultName = 'migrate';

    protected function configure()
    {
        $this->setDescription('Perform database migration');
    }

    /**
     * Execute command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $initializationRs = $this->initiateMigration();
        if ($initializationRs !== true) {
            $output->writeln('<error>Error in initializing data migration record table</>');
            return 0;
        }

        $taskRs = $this->getMigrationFile();
        if (!isset($taskRs[0])) {
            $output->writeln('<info>No migration</>');
            return 0;
        }

        $batch = MigrationHelper::getCurrentBatch();
        foreach ($taskRs as $v) {
            $output->write($v . "\t");
            $runRs = $this->runMigration($v, $batch, $output);
            if ($runRs == true) {
                $output->write('<info>succ.</>' . PHP_EOL);
            } else {
                $output->write(PHP_EOL);
            }
        }

        return 0;
    }

    /**
     * Initialize the migration record table
     *
     * @return bool
     */
    private function initiateMigration(): bool
    {
        $isExist = DB::getSchemaBuilder()->hasTable('migrations');
        if ($isExist == true) {
            return true;
        }

        DB::getSchemaBuilder()->create('migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('migration', 255)->default('');
            $table->mediumInteger('batch', false, true)->default(0);
            $table->timestamp('created_at')->nullable();
        });
        return true;
    }

    /**
     * Get the list of migration files to be executed
     *
     * @return array
     */
    private function getMigrationFile(): array
    {
        $fileRs = scandir(MigrationHelper::migrateFileBasePath());
        $result = array();
        foreach ($fileRs as $v) {
            $tmp = strpos($v, '.php');
            if ($tmp === false) {
                continue;
            }
            if (($tmp + 4) != strlen($v)) {
                continue;
            }
            $v = substr($v, 0, -4);
            $result[] = $v;
        }
        unset($fileRs);
        if (!isset($result[0])) {
            return [];
        }

        $runMigrations = DB::table('migrations')->pluck('migration')->toArray();
        foreach ($result as $k => $v) {
            if (in_array($v, $runMigrations)) {
                unset($result[$k]);
            }
        }
        unset($runMigrations);
        return array_values($result);
    }


    /**
     * Run the migration file
     *
     * @param string $fileName migration file name
     * @param int $batch migration batch
     * @param OutputInterface $output Interface
     * @return bool
     * @throws Exception
     */
    private function runMigration(string $fileName, int $batch, OutputInterface $output): bool
    {
        $filePath = MigrationHelper::migrateFileBasePath();
        $filePath .= DIRECTORY_SEPARATOR . $fileName . '.php';
        if (!file_exists($filePath)) {
            return false;
        }
        $className = MigrationHelper::getMigrateFileClass($fileName);
        if ($className == '') {
            return false;
        }
        if (class_exists($className)) {
            return false;
        }

        require_once $filePath;
        unset($filePath);

        $classMethod = get_class_methods($className);
        if (!is_array($classMethod) || !in_array('up', $classMethod)) {
            return false;
        }
        unset($classMethod);

        $migrate = new $className;
        try {
            $migrate->up();
            unset($className, $migrate);
        } catch (Exception $e) {
            $output->write(PHP_EOL);
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return false;
        }

        $lastId = DB::table('migrations')->insertGetId([
            'migration' => $fileName,
            'batch' => $batch,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        if ($lastId <= 0) {
            throw new Exception('After the migration file is executed, the error is inserted into the migration record table');
        }
        return true;
    }
}
