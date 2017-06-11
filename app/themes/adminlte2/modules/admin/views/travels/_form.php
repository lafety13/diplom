<?php
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Travels */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="travels-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'date')->textInput(['value' => date("F j, Y, g:i a"), 'readonly' => true])?>

    <?= $form->field($model, 'preview_image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]); ?>

        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add to' : 'Update', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('return','index', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
    <br />
    <?php ActiveForm::end(); ?>
</div>
