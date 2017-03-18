<?php

namespace app\common;

use app\common\components\PluginBaseController;
use yii2mod\rbac\filters\AccessControl;
use yii\base\UserException;

class AdminPluginController extends PluginBaseController
{
    public $layout = '/main';

    public function init(){
        parent::init();
        $this->attachBehaviors([
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    throw new UserException('You do not have permission to access this page!');
                }
            ],
        ]);
    }

}