<?php
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

    <?=
    $form->field($model, 'text')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'full',
            'inline' => false,
        ],
    ]);
    ?>

    <?= $form->field($model, 'author_id')->textInput(['value' => Yii::$app->user->getId(), 'readonly' => true])?>

    <?= $form->field($model, 'date')->textInput(['value' => date("F j, Y, g:i a"), 'readonly' => true])?>

    <?= $form->field($model, 'preview_image')->fileInput() ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Add to' : 'Update', ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('return','index', ['class' => 'btn btn-default btn-sm']) ?>
    </div>
    <br />
    <?php ActiveForm::end(); ?>
</div>
