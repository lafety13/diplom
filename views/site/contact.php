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


