<?php

use mihaildev\ckeditor\CKEditor;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = "Blog";

?>
<div class="content-wrapper">
            <div class="inner-container container">
                <div class="row">
                    <div class="section-header col-md-12">
                        <h2>Our Blog</h2>
                        <span>Subtitle Goes Here</span>
                    </div> <!-- /.section-header -->
                </div> <!-- /.row -->
                <div class="row">
                    <div class="blog-masonry masonry-true">

                        <?php

                        foreach ($articles as $article): ?>
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="<?=Url::to("../images/blog/{$article->preview_image}", true)?>" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="<?=Yii::$app->getUrlManager()->createUrl(['site/article', 'id' => $article->id])?>" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="<?=Yii::$app->getUrlManager()->createUrl(['site/article', 'id' => $article->id])?>"><?=$article->title?></a></h3>
                                    <span class="blog-meta"><?=$article->date?></span>
                                    <a href="#"><?=\app\modules\admin\models\Blog::getAuthor($article->author_id)->username?></a>

                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <?php endforeach;?>




                    </div> <!-- /.blog-masonry -->
                </div> <!-- /.row -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="pagination text-center">
                            <?=LinkPager::widget([
                                'pagination' => $pages,
                             //   'activePageCssClass' => 'active',
                                //'linkOptions' => ['style' => "border: 1px solid #e97e0a;"]
                            ]);?>
                        </div> <!-- /.pagination -->
                    </div> <!-- /.col-md-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.inner-content -->
        </div> <!-- /.content-wrapper -->