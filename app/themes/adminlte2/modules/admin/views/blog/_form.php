<?php
use kartik\file\FileInput;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Blog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="blog-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'text')->widget(\xvs32x\tinymce\Tinymce::className(), [
        //TinyMCE options
        'pluginOptions' => [
        'plugins' => [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
        "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        'toolbar1' => "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        'toolbar2' => "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor ",
        'image_advtab' => true,
        'filemanager_title' => "Filemanager",
        //'language' => ArrayHelper::getValue(explode('_', Yii::$app->language), '0', Yii::$app->language),
        ],
        //Widget Options
        'fileManagerOptions' => [
        //Upload Manager Configuration
        'configPath' => [
        //path from base_url to base of upload folder with start and final /
        'upload_dir' => '/web/uploads/filemanager/source/',
        //relative path from filemanager folder to upload folder with final /
        'current_path' => '../../../../../web/uploads/filemanager/source/',
        //relative path from filemanager folder to thumbs folder with final / (DO NOT put inside upload folder)
        'thumbs_base_path' => '../../../../../web/uploads/filemanager/thumbs/'
        ]
        ]
        ])
    ?>

    <?= $form->field($model, 'author_id')->textInput(['value' => Yii::$app->user->getId(), 'readonly' => true])?>

    <?= $form->field($model, 'date')->textInput(['value' => date("F j, Y, g:i a"), 'readonly' => true])?>

    <?= $form->field($model, 'preview_image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]); ?>


    <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add to' : 'Update', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('return','index', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
    <br />
    <?php ActiveForm::end(); ?>
</div>
