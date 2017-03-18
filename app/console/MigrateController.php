<?php

namespace app\console;

use yii\base\InvalidConfigException;
use yii\console\controllers\MigrateController as BaseMigrateController;
use yii;
use yii\helpers\Console;
use app\modules\admin\models\PluginManager;
/**
 * Class MigrateController
 *
 * @package yii2mod\rbac\commands
 *
 * Below are some common usages of this command:
 *
 * ```
 * # creates a new migration named 'create_rule'
 * yii rbac/migrate/create create_rule
 *
 * # applies ALL new migrations
 * yii rbac/migrate
 *
 * # reverts the last applied migration
 * yii rbac/migrate/down
 * ```
 */
class MigrateController extends BaseMigrateController
{
    /**
     * @inheritdoc
     */
    public $migrationTable = '{{%migration}}';

    /**
     * @var string
     */
    public $defaultMigrationPath = '@app/migrations';

    /**
     * @inheritdoc
     */
    public $migrationPath = '';

    /**
     * @inheritdoc
     */
    public $templateFile = '@yii/views/migration.php';

    protected $_plugin_migration_paths = [];

    /**
     *  migrationPath yii migrate --migrationPath=$path,
     * migrationPath defaultMigrationPath  plugin migrations
     *
     * method beforeAction migrationPath
     */
    public function generateMigrationPath()
    {
        //
        if($this->migrationPath != ''){
            $path = Yii::getAlias($this->migrationPath);
            if(is_dir($path)){
                $this->_plugin_migration_paths[] = $path;
            }else{
                throw new InvalidConfigException("Migration failed. Directory specified in migrationPath doesn't exist: {$this->migrationPath}");
            }

        }else{
            try {
                $setupedPlugins = PluginManager::GetSetupedPlugins();
                if ($setupedPlugins && is_array($setupedPlugins)){
                    foreach ($setupedPlugins as $plugin) {
                        $pluginId = isset($plugin['id']) ? $plugin['id'] : '';
                        $path = Yii::getAlias('@plugins') . DIRECTORY_SEPARATOR . "{$pluginId}" . DIRECTORY_SEPARATOR . "migrations";
                        if (is_dir($path)) {
                            $this->_plugin_migration_paths[] = $path;
                        }
                    }
                }
            }catch (yii\base\Exception $e){

            }
            $this->migrationPath = $this->defaultMigrationPath;
            $path = Yii::getAlias($this->migrationPath);
            if(is_dir($path)){
                $this->_plugin_migration_paths[] = $path;
            }
        }
        if(count($this->_plugin_migration_paths)>0){
            $need_include_paths = join(PATH_SEPARATOR,$this->_plugin_migration_paths);
            set_include_path(get_include_path() . PATH_SEPARATOR . $need_include_paths);
        }else{
            throw new InvalidConfigException('At least one of `defaultMigrationPath` or `migrationPath` or `migrationNamespaces` should be specified.');
        }
    }

    public function beforeAction($action){

        $this->generateMigrationPath();

        return parent::beforeAction($action);
    }

    protected function createMigration($class)
    {
        $class = trim($class, '\\');
        if (strpos($class, '\\') === false) {
            $file = $class . '.php';
            require_once($file);
        }

        return new $class();
    }

    protected function getNewMigrations()
    {
        $applied = [];
        foreach ($this->getMigrationHistory(null) as $class => $time) {
            $applied[trim($class, '\\')] = true;
        }

        $migrationPaths = [];
        foreach ($this->_plugin_migration_paths as $_path){
            $migrationPaths[] = $_path;
        }
        foreach ($this->migrationNamespaces as $namespace) {
            $migrationPaths[$namespace] = $this->getNamespacePath($namespace);
        }


        $migrations = [];
        foreach ($migrationPaths as $namespace => $migrationPath) {
            if (!file_exists($migrationPath)) {
                continue;
            }
            $handle = opendir($migrationPath);
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $migrationPath . DIRECTORY_SEPARATOR . $file;
                if (preg_match('/^(m(\d{6}_?\d{6})\D.*?)\.php$/is', $file, $matches) && is_file($path)) {
                    $class = $matches[1];
                    if (!empty($namespace) && !is_numeric($namespace)) {
                        $class = $namespace . '\\' . $class;
                    }
                    $time = str_replace('_', '', $matches[2]);
                    if (!isset($applied[$class])) {
                        $migrations[$time . '\\' . $class] = $class;
                    }
                }
            }
            closedir($handle);
        }
        ksort($migrations);

        return array_values($migrations);
    }

    public function getMigrationClassOfPlugin()
    {
        $dir = dir(Yii::getAlias($this->migrationPath));
        $migrations = [];
        while( ($file = $dir->read()) !== false){
            if($file != '.' && $file != '..'){
                $migrations[] = str_replace(".php","",$file);
            }
        }
        return $migrations;
    }

    public function actionDownPlugin()
    {
        $migrations = $this->getMigrationClassOfPlugin();

        if (empty($migrations)) {
            $this->stdout("No migration has been done before.\n", Console::FG_YELLOW);

            return static::EXIT_CODE_NORMAL;
        }

        $n = count($migrations);
        $this->stdout("Total $n " . ($n === 1 ? 'migration' : 'migrations') . " to be reverted:\n", Console::FG_YELLOW);
        foreach ($migrations as $migration) {
            $this->stdout("\t$migration\n");
        }
        $this->stdout("\n");

        $reverted = 0;
        if ($this->confirm('Revert the above ' . ($n === 1 ? 'migration' : 'migrations') . '?')) {
            foreach ($migrations as $migration) {
                if (!$this->migrateDown($migration)) {
                    $this->stdout("\n$reverted from $n " . ($reverted === 1 ? 'migration was' : 'migrations were') ." reverted.\n", Console::FG_RED);
                    $this->stdout("\nMigration failed. The rest of the migrations are canceled.\n", Console::FG_RED);

                    return static::EXIT_CODE_ERROR;
                }
                $reverted++;
            }
            $this->stdout("\n$n " . ($n === 1 ? 'migration was' : 'migrations were') ." reverted.\n", Console::FG_GREEN);
            $this->stdout("\nMigrated down successfully.\n", Console::FG_GREEN);
        }
    }
}
