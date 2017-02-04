<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
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
                            <div id="map_canvas" class="map-canvas"></div>
                        </div>
                    </div> <!-- /.col-md-5 -->
                </div> <!-- /.row -->
            </div> <!-- /.box-content -->
        </div> <!-- /.contact-form -->
    </div> <!-- /.inner-content -->
</div> <!-- /.content-wrapper -->

<!-- Google Map -->
<script src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="js/vendor/jquery.gmap3.min.js"></script>

<!-- Google Map Init-->
<script type="text/javascript">
    jQuery(function($){
        $('#map_canvas').gmap3({
            marker:{
                address: '40.717599,-74.005136'
            },
            map:{
                options:{
                    zoom: 17,
                    scrollwheel: false,
                    streetViewControl : true
                }
            }
        });
    });
</script>

