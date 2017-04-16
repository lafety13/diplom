<?php

use yii\helpers\Html;
use yii\bootstrap\Tabs;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Blogs';
$this->params['breadcrumbs'][] = $this->title;
?>
    <?php Pjax::begin(['options'=>['class'=>'nav-tabs-custom']]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  $content = '<p>'?>
    <?php  $content.= ' '.Html::a('Delete', "javascript:void(0);", ['class' => 'btn btn-sm btn-danger batchdelete']) ?>
    <?php  $content.= '</p>'?>
    <?php $content.=GridView::widget([
        'dataProvider' => $dataProvider,
        'layout'=>'{items}{summary}{pager}',
        'options'=>['id'=>'grid'],
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            [
                    'class' => 'yii\grid\CheckboxColumn',
                    'multiple' => true,
                    'name' => 'id'
                ],
            'id',
            'title',
            'short_description',
            'text:ntext',
            'author_id',
            // 'date',
            // 'preview_image',
            // 'tags',

            ['class' => 'app\common\grid\ActionColumn'],
        ],
    ]); ?>

    <?=  Tabs::widget([
        'items' => [
            [
                'label' =>  $this->title."Management",
                'content'=> $content,
                'active' => true
            ],
            [
                'label' => 'Add toBlog',
                'url'=>['create'],
            ]
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>

<?php $this->registerJs('
function oa_action(action,status,tips){
    var keys = $("#grid").yiiGridView("getSelectedRows");
    if(keys.length==0){
        noty({text: "Please select at least one data!",type:\'warning\'});
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
    oa_action("deletes",1,"Be sure to delete?");
});
');
?>
