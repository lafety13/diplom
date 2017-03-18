<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use voime\GoogleMaps\Map;

$this->title = 'Contact';

?>

<div class="content-wrapper">
    <div class="inner-container container">
        <div class="row">
            <div class="section-header col-md-12">
                <h2>Contact Page</h2>
                <span>Subtitle Goes Here</span>
            </div> <!-- /.section-header -->
        </div> <!-- /.row -->
        <div class="contact-form">
            <div class="box-content col-md-12">
                <div class="row">
                    <div class="col-md-7">
                        <p>
                            If you have business inquiries or other questions, please fill out the following form to contact us.
                        </p>
                        <h3 class="contact-title">Send Us Email</h3>
                        <div class="contact-form-inner">

                            <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

                                <div class="alert alert-success">
                                    Thank you for contacting us. We will respond to you as soon as possible.
                                </div>

                            <?php else: ?>

                                        <?php $form = ActiveForm::begin(['id' => 'contact-form',
                                            'layout'=>'horizontal',
                                           // 'options' => ['class' => 'form-control-mainstyle'],
                                            'fieldConfig' => [
                                                'template' => "{label}\n{beginWrapper}\n<div class='input-wrapper'>{input}</div>\n{hint}\n{error}\n{endWrapper}",
                                                'horizontalCssClasses' => [
                                                    'label' => 'col-xs-1 label-left-mainstyle',
                                                    'offset' => 'col-sm-offset-4',
                                                    'wrapper' => 'col-sm-8',
                                                    'error' => '',
                                                    'hint' => '',
                                                ],
                                            ],
                                         ]); ?>

                                            <?= $form->field($model, 'name')->label('Your Name:') ?>

                                            <?= $form->field($model, 'email')->label('Email Address:') ?>

                                            <?= $form->field($model, 'subject')->label('Subject:') ?>

                                            <?= $form->field($model, 'body')->label('Your message:')->textarea(['rows' => 6]) ?>

                                            <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                                                 //'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                                                'template' => '<div class="row"><div class="image-style">{image}</div><div class="col-lg-6">{input}</div></div>',
                                            ]) ?>

                                            <?= Html::submitInput('Send Message', ['class' => 'mainBtn', 'id' => 'submit']) ?>

                                        <?php ActiveForm::end(); ?>

                            <?php endif; ?>

                        </div> <!-- /.contact-form-inner -->
                        <div id="message"></div>
                    </div> <!-- /.col-md-7 -->
                    <div class="col-md-5">
                        <div class="googlemap-wrapper">
                            <div id="map_canvas" class="map-canvas">
                                <?=Map::widget([
                                    'zoom' => 17,
                                    'center' => [50.45651359, 30.39544165],
                                    'mapType' => Map::MAP_TYPE_ROADMAP,
                                    'markers' => [
                                        ['position' => [50.45651359, 30.39544165]],
                                    ],
                                ])?>
                            </div>
                        </div>
                    </div> <!-- /.col-md-5 -->
                </div> <!-- /.row -->
            </div> <!-- /.box-content -->
        </div> <!-- /.contact-form -->
    </div> <!-- /.inner-content -->
</div> <!-- /.content-wrapper -->


