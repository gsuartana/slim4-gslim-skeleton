<?php
namespace Gslim\Console\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Gslim\Console\Helpers\MigrationHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrationRollback extends Command
{
    protected static $defaultName = 'migrate:rollback';

    protected function configure()
    {
        $this->setDescription('Roll back the database migration');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $batch = MigrationHelper::getCurrentBatch();
        $batch -= 1;
        if ($batch <= 0) {
            $output->writeln('<info>No rollback</>');
            return 0;
        }

        $taskRs = $this->getRollbackList($batch);
        if (!isset($taskRs[0])) {
            $output->writeln('<info>No need to roll back</>');
            return 0;
        }

        foreach ($taskRs as $v) {
            if (!isset($v['id']) || !isset($v['migration'])) {
                continue;
            }
            $output->write($v['migration'] . "\t");
            $runRs = $this->runRollback($v['id'], $v['migration'], $output);
            if ($runRs == true) {
                $output->write('<info>rollback</>' . PHP_EOL);
            } else {
                $output->write(PHP_EOL);
            }
        }

        return 0;
    }

    /**
     * Get the list of files to be rolled back
     *
     * @param int $batch migration batch
     * @return array
     */
    private function getRollbackList(int $batch): array
    {
        $listRs = DB::table('migrations')->select('id', 'migration')
            ->where('batch', $batch)
            ->orderBy('id', 'desc')
            ->get();
        $return = array();
        foreach ($listRs as $v) {
            $return[] = [
                'id' => $v->id,
                'migration' => $v->migration,
            ];
        }
        return $return;
    }

    /**
     *  Run migration rollback
     *
     * @param int $migrateId  migration record ID
     * @param string $fileName migration file name
     * @param OutputInterface $output
     * @return bool
     * @throws Exception
     */
    private function runRollback(int $migrateId, string $fileName, OutputInterface $output): bool
    {
        $filePath = MigrationHelper::migrateFileBasePath();
        $filePath .= DIRECTORY_SEPARATOR . $fileName . '.php';
        if (!file_exists($filePath)) {
            throw new Exception($fileName . 'file does not exist');
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
        if (!is_array($classMethod) || !in_array('down', $classMethod)) {
            return false;
        }
        unset($classMethod);

        $migrate = new $className;
        try {
            $migrate->down();
            unset($className, $migrate);
        } catch (Exception $e) {
            $output->write(PHP_EOL);
            $output->writeln('<error>' . $e->getMessage() . '</>');
            return false;
        }

        $delRs = DB::table('migrations')->where([
            'id' => $migrateId,
            'migration' => $fileName,
        ])->delete();
        if ($delRs !== 1) {
            throw new Exception('After the migration file is rolled back, delete the migration record error');
        }

        return true;
    }
}
