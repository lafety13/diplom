<?php

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
                                    <p><?=$article->short_description?></p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <?php endforeach;?>

                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-2.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">Brigette Brown on Umbrellas</a></h3>
                                    <span class="blog-meta">8 November 2084 by Christina</span>
                                    <p><a href="http://www.templatemo.com/preview/templatemo_423_artcore">Artcore</a> is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by is free HTML5 template by <b class="blue">template</b><b class="green">mo</b>. There are total 12 HTML pages. Credit goes to <a rel="nofollow" href="http://unsplash.com">Unsplash</a> for images.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-3.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">An Open Letter to Larry Page</a></h3>
                                    <span class="blog-meta">6 November 2084 by Michael</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-4.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">The Night-Side of Hospitals</a></h3>
                                    <span class="blog-meta">4 November 2084 by George</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-5.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">A Love Letter to the City</a></h3>
                                    <span class="blog-meta">2 November 2084 by Michael</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-6.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">The Essence of a Teapot</a></h3>
                                    <span class="blog-meta">31 October 2084 by George</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-7.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">Design and Violence Debate</a></h3>
                                    <span class="blog-meta">4 November 2084 by Tawana</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-8.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">Porto Design Summer School</a></h3>
                                    <span class="blog-meta">4 November 2084 by Christina</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
                        <div class="post-masonry col-md-4 col-sm-6">
                            <div class="blog-thumb">
                                <img src="images/blog/blog-9.jpg" alt="">
                                <div class="overlay-b">
                                    <div class="overlay-inner">
                                        <a href="blog-single.html" class="fa fa-link"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="blog-body">
                                <div class="box-content">
                                    <h3 class="post-title"><a href="blog-single.html">War of Streets and Houses</a></h3>
                                    <span class="blog-meta">4 November 2084 by George</span>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias, deleniti, id quibusdam aut optio saepe soluta tempore neque voluptatum.</p>
                                </div>
                            </div>
                        </div> <!-- /.post-masonry -->
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