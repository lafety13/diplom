<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Travel";
?>
<div class="content-wrapper">
    <div class="inner-container container">
        <div class="row">
            <div class="section-header col-md-12">
                <h2>Blog Single</h2>
                <span>Subtitle Goes Here</span>
            </div> <!-- /.section-header -->
        </div> <!-- /.row -->
        <div class="row">
            <div class="blog-image col-md-12">
                <img src="<?=Url::to("../web/uploads/filemanager/source/{$article->preview_image}", true)?>" alt="">
            </div> <!-- /.blog-image -->
            <div class="blog-info col-md-12">
                <div class="box-content">
                    <h2 class="blog-title"><?=$article->title?></h2>
                    <span class="blog-meta">Date: <?=$article->date?></span>

                    <p><?=$article->text?></p>
                </div>
            </div> <!-- /.blog-info -->


    </div> <!-- /.content-wrapper -->
