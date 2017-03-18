<?php
/**
 * 插件管理者
 * 插件id,插件目录，必须为小写
 * @author xiongchuan <xiongchuan@luxtonenet.com>
 */
namespace app\modules\admin\models;
use yii;
use app\common\SystemConfig;
use yii\helpers\FileHelper;
use yii\base\ErrorException;
use yii\helpers\Json;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class PluginManager
{
    const STATUS_SUCCESS = 1;
    const STATUS_ERROR   = 0;
    const ERROR_NEEDED   = 110;
    const ERROR_NOTATLOCAL = 120;
    const ERROR_MIGRATE = 130;

    const PLUGIN_TYPE_ADMIN = "ADMIN";
    const PLUGIN_TYPE_API   = "API";
    const PLUGIN_TYPE_HOME  = "HOME";

    const PLUGIN_CONFIG_ID_RECORD_KEY = "PLUGIN_CONFIG_IDS";

    static private $_plugins = array();
    static private $_setupedplugins = array();

    const YII_COMMAND   = '@root/yii';
    const MIGRATE_UP    = 'up';
    const MIGRATE_DOWN  = 'down-plugin';
    const MIGRATION_DEFAULT_DIRNAME = 'migrations';

    static public $isShowMsg = 0;

    static public function setShowMsg($value)
    {
        static::$isShowMsg = $value;
    }

    /**
     *
     * @app/themes/adminlte2/views/plugin-manager/local.php
     *
     * <code>
    window.onmessage = function (msg,boxId) {
        var box = [];
        if(boxId != ''){
            box = $('#'+boxId);
        }
        if(box.length>0){
            box.append(msg);
        }else{
            $('.modal-body').append(msg);
        }
    }
     * </code>
     *
     * @param $msg
     * @param int $rn
     * @param string $type
     * @param string $boxId
     */
    static public function showMsg($msg,$rn=1,$type='info',$boxId='')
    {
        if(!static::$isShowMsg){
            return;
        }
        $color='';
        switch ($type){
            case 'info':
                $color='';
                break;
            case 'success':
                $color = 'green';
                break;
            case 'error':
                $color = 'red';
                break;
            default:
                break;

        }
        if($color){
            $str = "<span style=\"color:{$color}\">$msg</span>".($rn == 1 ? '<br />' : '');
        }else{
            $str = "$msg".($rn == 1 ? '<br />' : '');
        }

        $str = str_replace(["'","\n"],["\"",""],$str);
        echo "<script>parent.onmessage('$str','$boxId');</script>";
        ob_flush();
        flush();
    }

    static public function GetSetupedPlugins()
    {
        if(empty(static::$_setupedplugins)){
            $plugins = SystemConfig::Get('',null,SystemConfig::CONFIG_TYPE_PLUGIN);
            foreach ($plugins as $plugin){
                try{
                    static::$_setupedplugins[$plugin['cfg_name']] = Json::decode($plugin['cfg_value'],true);
                }catch (InvalidParamException $e){
                    static::$_setupedplugins[$plugin['cfg_name']] = $plugin['cfg_value'];
                }
            }
        }
        return static::$_setupedplugins;
    }

    static public function PluginSetupedCompleted($pluginid,array $config)
    {
        $record_key = isset(static::$_plugins[$pluginid][static::PLUGIN_CONFIG_ID_RECORD_KEY]) ? static::$_plugins[$pluginid][static::PLUGIN_CONFIG_ID_RECORD_KEY] : [];
        $cfg_value = Json::encode(array_merge($config,[static::PLUGIN_CONFIG_ID_RECORD_KEY=>$record_key]));
        $params = array(
            'cfg_value'   => $cfg_value,
            'cfg_comment' => $config['name'],
            'cfg_type'    =>SystemConfig::CONFIG_TYPE_PLUGIN
        );
        SystemConfig::Set($pluginid,$params);
        return true;
    }

    static public function GetPluginConfig($pluginid,$cache=true,$dir=null,$checkDependency = true)
    {
        $dir = $dir ? $dir : static::GetPluginPath($pluginid);
        $config = array(
            'setup'  => static::IsSetuped($pluginid),
            'config' => false
        );
        $pluginconfigfile = $dir ."/config.php";
        if(is_file($pluginconfigfile)){
            if(!static::ParsePluginConfig($pluginid))return false;
            $config['config'] = require $pluginconfigfile;
            //检查依赖插件
            if($checkDependency){
                static::CheckDependency($config['config']);
            }
        }
        if($cache){
            static::$_plugins[$pluginid] = $config;
        }
        return $config;
    }

    /**
     *
     * @param $type string  all:setuped:,new:
     * @param $page int
     * @param $pageSize int
     * @return array|boolean
     */
    static public function GetPlugins($type="all",$page=1,$pageSize=20)
    {
        //Get the data source
        $setupedplugins = static::GetSetupedPlugins();
        if("setuped"==$type){
            $fileArray = array_map('strtolower',array_keys($setupedplugins));
        }else{
            $pluginDir = Yii::getAlias('@plugins');
            $fileArray = array_slice(scandir($pluginDir,0),2);

            if("new" == $type){
                $setuped = array_map('strtolower',array_keys($setupedplugins));
                $fileArray = array_diff($fileArray, $setuped);
            }
        }
        //Get the end of the data source
        if($pageSize <=0){
            $pageSize = 20;
        }
        $total = count($fileArray);
        $pages = ceil($total/$pageSize);
        if($page<=0){
            $page = 1;
        }
        if($page>=$pages){
            $page = $pages;
        }
        $start = ($page-1)*$pageSize;
        $fileArraySlice = array_slice($fileArray, $start,$pageSize);

        if(!empty($fileArraySlice)){
            foreach($fileArraySlice as $pluginid){
                //Filter unqualified plugin
                if(!static::ParsePluginConfig($pluginid)){
                    continue;
                }
                static::$_plugins[$pluginid] = array(
                    'setup'  => static::IsSetuped($pluginid),
                    'config' => false
                );
                $pluginconfigfile = static::GetPluginPath($pluginid)."/config.php";
                if(is_file($pluginconfigfile)){
                    static::$_plugins[$pluginid]['config'] = require $pluginconfigfile;
                    //Check dependency plugins
                    static::CheckDependency(static::$_plugins[$pluginid]['config']);
                }
            }
            $result = array(
                'page' => $page,
                'pageSize' => $pageSize,
                'total' => $total,
                'pages' => $pages,
                'data'  => static::$_plugins
            );
            return $result;
        }
        return false;
    }


    /**
     * Get the plugin path
     */
    static public function GetPluginPath($pluginid)
    {
        return Yii::getAlias('@plugins').DIRECTORY_SEPARATOR.strtolower($pluginid).DIRECTORY_SEPARATOR;
    }

    /**
     * Delete the value inside the static variable array
     */
    static public function PluginDeleteStaticVar($pluginid)
    {
        if(!empty(static::$_setupedplugins)){
            unset(static::$_setupedplugins[$pluginid]);
        }
    }

    /**
     * To determine whether it has been installed
     */
    static public function IsSetuped($pluginid)
    {
        if(empty(static::$_setupedplugins)){
            static::GetSetupedPlugins();
        }
        return isset(static::$_setupedplugins[$pluginid]) ? 1 : 0;
    }

    /**
     * Detect dependencies
     */
    static public function CheckDependency(array &$config)
    {
        $unsetuped = array();
        if(is_array($config)){
            $dependencies = isset($config['dependencies']) ? $config['dependencies'] : '';
            $array = $dependencies ? explode(",", $dependencies) : '';
            if(!empty($array)){
                static::showMsg('');
                foreach($array as $pluginid){
                    if($pluginid){
                        static::showMsg('|depends on the plugin:'.$pluginid.'Whether to install...',0);
                        if(0 == static::IsSetuped($pluginid)){
                            $unsetuped[] = $pluginid;
                            static::showMsg('Not Installed',1,'error');
                        }else{
                            static::showMsg('Installed',1,'success');
                        }
                    }
                }
            }
        }
        $config['needed'] = join(",",$unsetuped);
    }

    /**
     * Plugin into route
     */
    static public function PluginInjectRoute(array $conf)
    {
        if(isset($conf['route']) && !empty($conf['route']) && is_array($conf['route'])){
            $params = [
                'cfg_value'   => Json::encode($conf['route']),
                'cfg_comment' => $conf['id'],
                'cfg_pid'     => 0,
                'cfg_order'   => 0,
                'cfg_type'    => 'ROUTE'
            ];
            $cfg_name = strtoupper("plugin_{$conf['id']}_route");
            $lastid = SystemConfig::Set($cfg_name,$params);
            static::RecordPluginConfigId($conf['id'],$lastid);
        }
    }

    /**
     * config system_config
     * @param array $conf
     */
    static public function PluginInjectConfig(array $conf)
    {
        if(isset($conf['config']) && !empty($conf['config']) && is_array($conf['config'])){
            foreach ($conf['config'] as $config){
                if(isset($config['cfg_name']) && !empty($config['cfg_name'])){
                    $params = [
                        'cfg_name'  => $config['cfg_name'],
                        'cfg_value' => isset($config['cfg_value']) ? $config['cfg_value'] : '',
                        'cfg_comment' => isset($config['cfg_comment']) ? $config['cfg_comment'] : '',
                    ];
                    $lastid = SystemConfig::Set($config['cfg_name'],$params);
                    static::RecordPluginConfigId($conf['id'],$lastid);
                }
            }
        }
    }

    /**
     * pluings[pluginId] = ['config_ids'=>[]]
     * @param $pluginId plugin id
     * @param $configId system_config id
     */
    static public function RecordPluginConfigId($pluginId,$configId)
    {
        if( $configId>0){
            if(!isset(static::$_plugins[$pluginId])){
                static::$_plugins[$pluginId] = [];
            }
            if(!isset(static::$_plugins[$pluginId][static::PLUGIN_CONFIG_ID_RECORD_KEY])){
                static::$_plugins[$pluginId][static::PLUGIN_CONFIG_ID_RECORD_KEY] = [];
            }
            array_push(static::$_plugins[$pluginId][static::PLUGIN_CONFIG_ID_RECORD_KEY],$configId);
        }
    }

    /**
     * @param $pluginId
     * @param $cfg_name
     * @param array $menus
     */
    static public function _PluginInjectMenu($pluginId,$cfg_pid,array $menus)
    {
        $plugin_last_config = static::PluginLastSavedConfig($pluginId);
        foreach ($menus as $menu){
            $params = [
                'cfg_value'   => isset($menu['cfg_value']) ? $menu['cfg_value'] : '',
                'cfg_comment' => isset($menu['cfg_comment']) ? $menu['cfg_comment'] : '',
                'cfg_pid'     => $cfg_pid ==0 ? (isset($menu['cfg_pid']) ? $menu['cfg_pid'] : 0) : $cfg_pid,
                'cfg_order'   => isset($menu['cfg_order']) ? $menu['cfg_order'] : 0
            ];
            //Use old configuration information
            if(!empty($plugin_last_config) && isset($plugin_last_config['menus']) && isset($plugin_last_config['menus'][$params['cfg_comment']])){
                $params['cfg_pid'] = $plugin_last_config['menus'][$params['cfg_comment']]['cfg_pid'];
                $params['cfg_order'] = $plugin_last_config['menus'][$params['cfg_comment']]['cfg_order'];
            }

            if(empty($params['cfg_value']) || empty($params['cfg_comment']))continue;
            if(is_array($params['cfg_value']) && isset($params['cfg_value']['url'])){
                $params['cfg_value'] = Json::encode($params['cfg_value']);
            }else{
                continue;
            }
            $lastPuginConfigId = SystemConfig::Set(SystemConfig::MENU_KEY,$params);
            static::RecordPluginConfigId($pluginId,$lastPuginConfigId);

            //Check if there are submenus
            if(isset($menu['items']) && is_array($menu['items'])){
                static::_PluginInjectMenu($pluginId,$lastPuginConfigId,$menu['items']);
            }
        }

    }

    static public function PluginInjectMigration($pluginid,$type)
    {
        $configRaw = static::GetPluginConfig($pluginid,true,null,false);
        $conf      = $configRaw['config'];
        if(!$conf){
            //plugin 目录异常
            static::showMsg("");
            static::showMsg("Get plugin configuration failed, please check plug-in is normal!",1,'error');
            return false;
        }
        if(isset($conf['migrationDirName']) && !empty($conf['migrationDirName'])){
            $migrationDirName = $conf['migrationDirName'];
        }else{
            $migrationDirName = static::MIGRATION_DEFAULT_DIRNAME;
        }
        $migrationPath = Yii::getAlias('@plugins/'.$pluginid.'/'.$migrationDirName);
        if(is_dir($migrationPath)){
            static::showMsg("need",1,'success');
            static::showMsg("Start executing the Migrate operation...");
            $yii = Yii::getAlias(static::YII_COMMAND);
            $params = "--migrationPath=$migrationPath --interactive=0";
            $action = "migrate/";
            switch ($type){
                case static::MIGRATE_UP:
                    $action .= static::MIGRATE_UP;
                    break;
                case static::MIGRATE_DOWN:
                    $action .= static::MIGRATE_DOWN;
                    break;
                default:
                    break;
            }
            $cmds = [
                $yii,
                $action,
                $params
            ];
            $cmd = join(" ",$cmds);
            static::showMsg("<p id='cmd_box' style='background-color: #2c763e;color:#f5db88'>",0);
            //执行
            $handler = popen($cmd, 'r');
            static::showMsg("cmd:  ".$cmd."\n",1,'','cmd_box');
            while (!feof($handler)) {
                $output = fgets($handler,1024);
                static::showMsg($output,1,'','cmd_box');
            }
            pclose($handler);

            static::showMsg("</p>",0);
        }else{
            static::showMsg("No need",1,'success');
        }
        return true;
    }

    /**
     * Plugin menu injection
     */
    static public function PluginInjectMenu(array $conf)
    {
        $pluginId = $conf['id'];
        if(isset($conf['menus']) && is_array($conf['menus']) && !empty($conf['menus'])){
            static::_PluginInjectMenu($pluginId,0,$conf['menus']);
        }
    }

    static public function SetupLocalPlugin($pluginName)
    {
        //Parsing configuration
        $config = static::ParsePluginConfig($pluginName);
        //Perform the operation according to the configuration
        foreach ($config as $action => $conf) {
            if(method_exists(self, $action)){
                static::$action($conf);
            }
        }
    }

    /**
     * Parsing configuration
     */
    static public function ParsePluginConfig($pluginid,$conf=null)
    {
        if(is_array($conf)){
            $config = $conf;
        }else{
            $configfile = static::GetPluginPath($pluginid)."/config.php";
            if(!is_file($configfile))return false;
            $config = require $configfile;
        }

        if(!isset($config['id']) || $pluginid != $config['id']){
            return false;
        }
        if(!isset($config['version']) ||
            !isset($config['name']) ||
            !isset($config['type']) ||
            empty($config['version']) ||
            empty($config['name']) ||
            empty($config['type'])
        ){
            return false;
        }
        return true;
    }

    /**
     * system_config
     * @param $pluginid string
     */
    static public function PluginDeleteDBConfig($pluginid)
    {
        $plugins = SystemConfig::Get($pluginid,null,SystemConfig::CONFIG_TYPE_PLUGIN);
        if($plugins && is_array($plugins))foreach ($plugins as $plugin){
            try{
                $value = Json::decode($plugin['cfg_value']);
                $config_ids = isset($value[static::PLUGIN_CONFIG_ID_RECORD_KEY]) ? $value[static::PLUGIN_CONFIG_ID_RECORD_KEY] : [];
                if(is_array($config_ids) && !empty($config_ids))foreach ($config_ids as $id){
                    $configRaw = SystemConfig::GetById($id);
                    if($configRaw && in_array($configRaw['cfg_name'],[SystemConfig::MENU_KEY,SystemConfig::HOMEMENU_KEY])){
                        static::PluginSaveOldConfig($pluginid,$configRaw);
                    }
                    SystemConfig::Remove($id);
                }
            }catch (InvalidParamException $e){

            }
            //删除自己
            SystemConfig::Remove($plugin['id']);
        }
        return false;
    }

    /**
     *
     * @param $pluginid
     * @param $config
     */
    static public function PluginSaveOldConfig($pluginid,$config)
    {
        static::showMsg('<br/>Save the plugin configuration information to the plugin directory...');
        $Dir = static::GetPluginPath($pluginid).'unsetup/';
        if(!is_dir($Dir)){
            @mkdir($Dir,0777);
        }
        $old_config_path = $Dir.'unsetup_save_config.php';
        if(!is_file($old_config_path)){
            @file_put_contents($old_config_path,'');
        }
        if(is_writable($Dir) && is_writable($old_config_path)){
            $content = file_get_contents($old_config_path);
            $save_config = [];
            if($content){
                try{
                    $save_config = Json::decode($content,true);
                }catch (InvalidParamException $e){
                }
            }
            if( is_array($save_config) ){
                if(!isset($save_config["menus"])){
                    $save_config["menus"] = [];
                }
            }else{
                $save_config = [];
                $save_config["menus"] = [];
            }
            $save_config["menus"][$config['cfg_comment']] = $config;
            file_put_contents($old_config_path,Json::encode($save_config));
            static::showMsg("Configure the path:$old_config_path ... Save finished!");
        }else{
            static::showMsg("Configure the path:$old_config_path ... Do not write, skip!");
        }
    }

    /**
     *
     * @param $pluginid
     * @return array|mixed
     */
    static public function PluginLastSavedConfig($pluginid)
    {
        $path = static::GetPluginPath($pluginid).'unsetup/unsetup_save_config.php';
        $save_config = [];
        if(is_file($path)){
            $content = file_get_contents( $path );
            try{
                $save_config = Json::decode($content,true);
            }catch (InvalidParamException $e){
            }
        }
        return $save_config;
    }


    /**
     *
     * @param $pluginid
     */
    static public function setup($pluginid)
    {
        static::showMsg("Start installing plugins...");
        $data = array("status"=>static::STATUS_ERROR,'msg'=>'unknown mistake');
        //Check if it has been installed
        if( 0 == static::IsSetuped($pluginid)){
            static::showMsg("Get the plugin configuration...",0);
            $configRaw = static::GetPluginConfig($pluginid,false,null,false);
            $config = $configRaw['config'];
            static::showMsg("carry out",1,'success');
            static::showMsg("Detects plug-in dependencies...",0);
            static::CheckDependency($config);
            if(isset($config['needed']) && !empty($config['needed'])){
                static::showMsg("");
                static::showMsg("Please install the missing dependencies first:{$config['needed']}，Install this plugin again！",1,'error');
                $data['status'] = static::STATUS_ERROR;
                $data['error_no'] = static::ERROR_NEEDED;
                $data['msg']      = "Please install the missing dependent plug-in, then install this plug-in!";
                return $data;
            }
            static::showMsg("Detection is complete",1,'success');
            if($config){
                static::showMsg("Detects the need to perform Migrate...",0);

                $rn = static::PluginInjectMigration($pluginid,static::MIGRATE_UP);
                if(!$rn){
                    $data['status'] = static::STATUS_ERROR;
                    $data['error_no'] = static::ERROR_MIGRATE;
                    $data['msg']      = "Plugin Migrate failed, please check plugin Migration configuration!";
                    return $data;
                }
                static::showMsg("Start the registration menu...",0);

                static::PluginInjectMenu($config);
                static::showMsg("carry out",1,'success');
                static::showMsg("Start registering routes...",0);
                static::PluginInjectRoute($config);
                static::showMsg("carry out",1,'success');
                static::showMsg("Start registering system configuration...",0);
                static::PluginInjectConfig($config);
                static::showMsg("carry out",1,'success');
                static::showMsg("Save the plugin information to the database...",0);
                static::PluginSetupedCompleted($pluginid,$config);
                static::showMsg("carry out",1,'success');
                $data['status'] = static::STATUS_SUCCESS;
                $data['msg'] = "Successful installation";
                static::showMsg("The plugin is installed",1,'success');
                return $data;
            }else{
                static::showMsg("Plugin configuration file parsing error, please re-download and extract to the plug-in directory！",1,'error');
                $data['status'] = static::STATUS_ERROR;
                $data['error_no'] = static::ERROR_NOTATLOCAL;
                $data['msg']      = "Plug-in does not exist in the local, please go to the plug-in mall download and install!";
                return $data;
            }
        }else{
            static::showMsg("The plugin is already installed!",1,'success');
            $data = array("status"=>static::STATUS_ERROR,'msg'=>'Has been installed');
        }
        return $data;
    }

    /**
     *
     * @param $pluginid
     */
    static public function unsetup($pluginid)
    {
        static::showMsg('Start uninstalling the plugin...');
        static::showMsg('Detects the need to perform Migrate...',0);
        $rn = static::PluginInjectMigration($pluginid,static::MIGRATE_DOWN);
        if(!$rn){
            $data['status'] = static::STATUS_ERROR;
            $data['error_no'] = static::ERROR_MIGRATE;
            $data['msg']      = "Plugin Migrate failed, please check plugin Migration configuration!";
            return $data;
        }
        static::showMsg('Delete the database configuration...',0);
        static::PluginDeleteDBConfig($pluginid);
        static::showMsg('carry out',1,'success');
        static::PluginDeleteStaticVar($pluginid);
        static::showMsg('Uninstall is complete!',1,'success');
        $data = array("status"=>static::STATUS_SUCCESS,'msg'=>'Uninstall is complete');
        return $data;
    }

    /**
     *
     * @param $pluginid string
     */
    static public function delete($pluginid)
    {
        static::showMsg('Start deleting the plugin...');
        try{
            $pluginDir = static::GetPluginPath($pluginid);
            FileHelper::removeDirectory($pluginDir);
            static::showMsg('Delete is complete',1,'success');
            return ['status'=>static::STATUS_SUCCESS,'msg'=>'successfully deleted'];
        }catch(ErrorException $e){
            static::showMsg('Delete failed (no permissions available)，Please manually remove the plugin related files and directories!',1,'error');
            static::showMsg($e->getMessage(),1,'error');
            return ['status' => static::STATUS_ERROR,'msg' => "Delete failed (no permissions), please manually remove the plug-in related files and directories!"];
        }
    }

}
