<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\common\EditableColumn;
use yii\widgets\Pjax;
use yii\bootstrap\Tabs;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var amnah\yii2\user\Module $module
 * @var amnah\yii2\user\models\search\UserSearch $searchModel
 * @var amnah\yii2\user\models\User $user
 * @var amnah\yii2\user\models\Role $role
 */

$module = $this->context->module;
$controller = $this->context;
$user = $module->model("User");
$role = $module->model("Role");
$this->title = Yii::t('user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>



<?php Pjax::begin(['options'=>['class'=>'nav-tabs-custom']]); ?>
        <?php  $content = '<p>'?>
        <?php  $content.= ' '.Html::a('Activation', "javascript:void(0);", ['class' => 'btn btn-xs btn-success batch-active']) ?>
        <?php  $content.= ' '.Html::a('Deactivate', "javascript:void(0);", ['class' => 'btn btn-xs btn-success batch-inactive']) ?>
        <?php  $content.= ' '.Html::a('Title', "javascript:void(0);", ['class' => 'btn btn-xs btn-primary batch-banned']) ?>
        <?php  $content.= ' '.Html::a('Cancel the title', "javascript:void(0);", ['class' => 'btn btn-xs btn-primary batch-unbanned']) ?>
        <?php  $content.= ' '.Html::a('Delete', "javascript:void(0);", ['class' => 'btn btn-xs btn-danger batchdelete']) ?>
        <?php  $content.= '</p>'?>
        <?php  $content.= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "{items}{summary}{pager}",
            'options'=>['id'=>'grid'],
            'columns' => [
                [
                    'class' => 'yii\grid\CheckboxColumn',//复选框
                    'multiple' => true,
                    'name' => 'uid',
                    'filterOptions'=>['style'=>'width:30px']
                ],

                [
                    'attribute' => 'id',
                    'filterOptions'=>['style'=>'width:30px']
                ],
                [
                    'attribute' => 'username',
                    'format'=>'raw',
                    'value' => function($model)use($controller){
                        return $model->username.($model->id == $controller->superadmin_uid ?
                                "<span data-toggle='tooltip' data-original-title='Super administrator' class='label label-success'>Ultra</span>" :"");
                    },
                    'filterOptions'=>['style'=>'width:100px']
                ],
                [
                    'attribute'=>'email',
                    'options'=>['style'=>'width:180px']
                ],
                //'profile.full_name',
                //'profile.timezone',
                [
                    'attribute'=>'created_at',
                    'options'=>['style'=>'width:130px']
                ],
                [
                    'class' => EditableColumn::className(),
                    'url' => ['change-role'],
                    'type' => 'select',
                    'editableOptions' => function ($model) use($role,$controller){
                        if($model->id == $controller->superadmin_uid)return false;
                        return [
                            'source' => $role::dropdown(),
                            'value' => $model->role_id,
                        ];
                    },
                    'attribute' => 'role_id',
                    'label' => Yii::t('user', 'Role'),
                    'filter' => $role::dropdown(),
                    'value' => function($model, $index, $dataColumn) use ($role) {
                        $roleDropdown = $role::dropdown();
                        return $roleDropdown[$model->role_id];
                    },
                    'options'=>['style'=>'width:80px']
                ],
                [
                    'label'=>'Activation',
                    'class' => EditableColumn::className(),
                    'url' => ['change-status'],
                    'type' => 'select',
                    'editableOptions' => function ($model) use($user,$controller){
                        if($model->id == $controller->superadmin_uid)return false;
                        $source = $user::statusDropdown();
                        krsort($source);
                        return [
                            'source' => $source,
                            'value' => $model->status,
                        ];
                    },
                    'attribute' => 'status',
                    'label' => Yii::t('user', 'Status'),
                    'filter' => $user::statusDropdown(),
                    'value' => function($model, $index, $dataColumn) use ($user) {
                        $statusDropdown = $user::statusDropdown();
                        return $statusDropdown[$model->status];
                    },
                    'options'=>['style'=>'width:80px']
                ],
                [
                    'label'=>'Disabled',
                    'attribute'=>'banned_at',
                    'filter'=>'',
                    'value'=>function($model){
                        return $model->banned_at ? "Disabled" : "Normal";
                    },
                    'options'=>['style'=>'width:80px']
                ],

                // 'password',
                // 'auth_key',
                // 'access_token',
                // 'logged_in_ip',
                // 'logged_in_at',
                // 'created_ip',
                // 'updated_at',
                // 'banned_at',
                // 'banned_reason',

                [
                    'class' => 'app\common\grid\ActionColumn',
                    'options'=>['style'=>'width:180px']
                ],
            ],
        ]); ?>
        <?=  Tabs::widget([
            'items' => [
                [
                    'label' =>  "User Management",
                    'content'=> $content,
                    'active' => true
                ],
                [
                    'label' => 'Add user',
                    'url'=>['create'],
                ]
            ],
        ]);
        ?>
<?php Pjax::end(); ?>

<?php
$this->registerJs('
function oa_action(action,status,tips){
    var keys = $("#grid").yiiGridView("getSelectedRows");
    if(keys.length==0){
        noty({text: "Please select at least one piece of data!",type:\'warning\'});
        return ;
    }
    if(tips == ""){
        $.ajax({
                url: action,
                type: \'post\',
                data: {ids:keys,status:status,_csrf:"'.Yii::$app->request->csrfToken.'"},
                success: function (data) {
                    // do something
                    if(data["code"] == 200){
                        noty({text: data.msg,type:\'success\'});
                        setTimeout(function(){location.href=oa_timestamp(location.href);},1000);
                    }else{
                        noty({text: data.msg,type:\'error\',timeout:1000});
                    }
                }
            });
    }else{
        yii.confirm(tips,function(){
            $.ajax({
                url: action,
                type: \'post\',
                data: {ids:keys,status:status,_csrf:"'.Yii::$app->request->csrfToken.'"},
                success: function (data) {
                    // do something
                    if(data["code"] == 200){
                        noty({text: data.msg,type:\'success\'});
                        setTimeout(function(){location.href=oa_timestamp(location.href);},1000);
                    }else{
                        noty({text: data.msg,type:\'error\',timeout:1000});
                    }
                }
            });
        });
    }
}
$(".batchdelete").on("click", function () {
    oa_action("/user/admin/deletes",1,"Be sure to delete?");
});
$(".batch-active").on("click", function () {
    oa_action("/user/admin/active",1,"");
});
$(".batch-inactive").on("click", function () {
    oa_action("/user/admin/active",0,"");
});
$(".batch-banned").on("click", function () {
    oa_action("/user/admin/banned",1,"");
});
$(".batch-unbanned").on("click", function () {
    oa_action("/user/admin/banned",0,"");
});
');

?>
