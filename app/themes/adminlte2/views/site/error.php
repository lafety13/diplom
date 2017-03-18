<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="content-wrapper">
    <div class="inner-container container">
        <div class="row">
            <div class="section-header col-md-12">
                <h2><?= Html::encode($this->title) ?></h2>
            </div> <!-- /.section-header -->
        </div> <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <div class="box-content">
                    <div class="text-center error-page">
                        <h1><?= nl2br(Html::encode($message)) ?></h1>
                        <p>
                            The above error occurred while the Web server was processing your request.
                        </p>
                        <p>
                            Please contact us if you think this is a server error. Thank you.
                        </p>
                        <p><a href="<?=Yii::$app->getHomeUrl()?>">&larr; Go back Home</a></p>
                    </div> <!-- /.text-center -->
                </div> <!-- /.box-content -->
            </div> <!-- /.col-md-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.inner-content -->
</div> <!-- /.content-wrapper -->