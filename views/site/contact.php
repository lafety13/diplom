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
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            Thank you for contacting us. We will respond to you as soon as possible.
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                                                                                                    Please configure the <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                ]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>



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
                        <p>This is an example of a contact page. You can set the contact page in your themes backend and add, remove and modify the input fields, text areas, dropdowns and checkboxes from your backend as well.</p>
                        <h3 class="contact-title">Send Us Email</h3>
                        <div class="contact-form-inner">
                            <form method="post" action="#" name="contactform" id="contactform">
                                <p>
                                    <label for="name">Your Name:</label>
                                    <input name="name" type="text" id="name">
                                </p>
                                <p>
                                    <label for="email">Email Address:</label>
                                    <input name="email" type="text" id="email">
                                </p>
                                <p>
                                    <label for="phone">Phone Number:</label>
                                    <input name="phone" type="text" id="phone">
                                </p>
                                <p>
                                    <label for="comments">Your message:</label>
                                    <textarea name="comments" id="comments"></textarea>
                                </p>
                                <input type="submit" class="mainBtn" id="submit" value="Send Message" />
                            </form>
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
                                    // 'markerFitBounds'=>true
                                ])?>
                            </div>
                        </div>
                    </div> <!-- /.col-md-5 -->
                </div> <!-- /.row -->
            </div> <!-- /.box-content -->
        </div> <!-- /.contact-form -->
    </div> <!-- /.inner-content -->
</div> <!-- /.content-wrapper -->


