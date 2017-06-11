<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Article";
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
                    <span class="blog-meta">Date: <?=$article->date?> <span style="padding-left: 25px">Author: <a href="#"><?=\app\modules\admin\models\Blog::getAuthor($article->author_id)->username?></a></span></span>

                    <p><?=$article->text?></p>
                    </div>
            </div> <!-- /.blog-info -->
            <div class="blog-tags col-md-12">
                <span>Tags</span>:
                <a href="#">Developmet</a>
                <a href="#">Inspiration</a>
                <a href="#">Web Design</a>
                <a href="#">Creative UI</a>
                <a href="#">templatemo</a>
            </div> <!-- /.blog-tags -->
        </div> <!-- /.row -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="comment-heading">Comments (<?=\app\modules\admin\models\Comment::getTotalCommentsOfArticle($article->id)?>)</h2>
                <div class="box-content">
                    <div class="comment">

                        <?php foreach ($comments as $comment): ?>
                                <div class="comment">
                                    <div class="comment-inner">
                                        <div class="author-avatar">
                                            <img src="/web/uploads/filemanager/source/default-avatar.jpg" alt="">
                                        </div>
                                        <div class="comment-body">
                                            <h4><?=$comment->user_name?></h4>
                                            <span><?=$comment->user_name?></span>
                                            <p><?=$comment->comment?></p>
                                        </div>
                                    </div>
                                </div>  <!-- /.comment -->
                        <?php endforeach; ?>

                </div> <!-- /.box-content -->
            </div> <!-- /.col-md-12 -->
        </div> <!-- /.row -->
        <div class="row">
            <div class="col-md-12 comment-form">
                <h2 class="comment-heading">Leave a Comment</h2>
                <div class="box-content">
                    <?php $form = ActiveForm::begin(); ?>
                    <p>
                        <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>
                    </p>

                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'article_id')->textInput(['value' => $article->id, 'readonly' => true])?>

                    <?= $form->field($model, 'comment')->textarea(['maxlength' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Add to' : 'Update', ['class' => 'btn btn-md btn-warning']) ?>
                    </div>
                    <br />
                    <?php ActiveForm::end(); ?>
                </div> <!-- /.box-content -->


            </div> <!-- /.comment-form -->
        </div> <!-- /.row -->
    </div> <!-- /.inner-content -->
</div> <!-- /.content-wrapper -->
