<?php
/**
 *  app\plugins\
 * @author chuan xiong <xiongchuan86@gmail.com>
 */
namespace app\modules\plugin;
use yii;
use yii\base\InvalidRouteException;
use yii\web\NotFoundHttpException;
class Module extends \yii\base\Module
{
    // public $controllerNamespace = '';

    public $pluginid = "";

    public $realRoute = "";

    public $controllerNamespace = 'app\plugins';

    public function init()
    {
        parent::init();
        $route = Yii::$app->requestedRoute;
        $array = explode("/",trim($route,"/"));
        if($array['0'] == $this->id){
            $pluginid = isset($array[1]) ? explode(":", $array[1]) : $array[1];
            $namespace = join("\\",$pluginid);
            $this->controllerNamespace = 'app\plugins\\' . strtolower($namespace) ;
            $this->pluginid = $pluginid[0];
            if(count($pluginid)>1){
                unset($array[0]);
                unset($array[1]);
                $this->realRoute = join("/",$array);
            }
        }
    }

    public function createController($route)
    {
        if(!$this->realRoute){
            $array = explode("/",$route);
            if(count($array)>=3 && $array[0] == $array[1]){
                $file = Yii::getAlias('@plugins')."/{$array[0]}/".ucfirst($array[0])."Controller.php";
                if(is_file($file)){
                    array_shift($array);
                    $route = join("/",$array);
                }
            }
        }
        $controller = parent::createController($this->realRoute ? $this->realRoute : $route);
        if(!$controller){
            $this->controllerNamespace = $this->controllerNamespace . '\\controllers' ;
            $route = str_replace($this->pluginid."/",'',$route,$i);
            $route = $i==2 ? $this->pluginid."/".$route : $route;//menu/menu/index,menu/menu
            $controller = parent::createController($this->realRoute ? $this->realRoute : $route);
        }
        return $controller;
    }

    public function beforeAction($action)
    {
        $this->setPluginViewPath();
        if (!parent::beforeAction($action)) {
            return false;
        }

        return true; // or false to not run the action
    }

    public function setPluginViewPath()
    {
        $path = Yii::getAlias('@plugins').DIRECTORY_SEPARATOR.$this->pluginid.DIRECTORY_SEPARATOR.'views';
        if(is_dir($path)){
            $this->setViewPath($path);
        }

    }
}
