<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="<?= Yii::$app->language ?>"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="<?= Yii::$app->language ?>"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="<?= Yii::$app->language ?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?= Yii::$app->language ?>"> <!--<![endif]-->
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <section id="pageloader">
        <div class="loader-item fa fa-spin colored-border"></div>
    </section> <!-- /#pageloader -->

    <header class="site-header container-fluid">
        <div class="top-header">
            <div class="logo col-md-6 col-sm-6">
                <h1><a href="<?=Yii::$app->getHomeUrl()?>"><em>Art</em>Core</a></h1>
                <span>Responsive HTML5 Template</span>
            </div> <!-- /.logo -->
            <div class="social-top col-md-6 col-sm-6">
                <ul>
                    <li><a href="#" class="fa fa-facebook"></a></li>
                    <li><a href="#" class="fa fa-twitter"></a></li>
                    <li><a href="#" class="fa fa-linkedin"></a></li>
                    <li><a href="#" class="fa fa-google-plus"></a></li>
                    <li><a href="#" class="fa fa-flickr"></a></li>
                    <li><a href="#" class="fa fa-rss"></a></li>
                </ul>
            </div> <!-- /.social-top -->
        </div> <!-- /.top-header -->
        <div class="main-header">
            <div class="row">
                <div class="main-header-left col-md-3 col-sm-6 col-xs-8">
                    <a id="search-icon" class="btn-left fa fa-search" href="#search-overlay"></a>
                    <div id="search-overlay">
                        <a href="#search-overlay" class="close-search"><i class="fa fa-times-circle"></i></a>
                        <div class="search-form-holder">
                            <h2>Type keywords and hit enter</h2>
                            <form id="search-form" action="#">
                                <input type="search" name="s" placeholder="" autocomplete="off" />
                            </form>
                        </div>
                    </div><!-- #search-overlay -->
                    <a href="#" class="btn-left arrow-left fa fa-angle-left"></a>
                    <a href="#" class="btn-left arrow-right fa fa-angle-right"></a>
                </div> <!-- /.main-header-left -->
                <div class="menu-wrapper col-md-9 col-sm-6 col-xs-4">
                    <a href="#" class="toggle-menu visible-sm visible-xs"><i class="fa fa-bars"></i></a>
                    <ul class="sf-menu hidden-xs hidden-sm">
                        <li class="active"><a href="<?=Yii::$app->getHomeUrl(); ?>">Home</a></li>
                        <li><a href="#">Booking</a></li>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Pages</a></li>
                        <li><a href="<?=Yii::$app->getUrlManager()->createUrl(['site/contact']); ?>">Contact</a></li>
                    </ul>
                </div> <!-- /.menu-wrapper -->
            </div> <!-- /.row -->
        </div> <!-- /.main-header -->
        <div id="responsive-menu">
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="#">Projects</a>
                    <ul>
                        <li><a href="projects-2.html">Two Columns</a></li>
                        <li><a href="projects-3.html">Three Columns</a></li>
                        <li><a href="project-details.html">Project Single</a></li>
                    </ul>
                </li>
                <li><a href="#">Blog</a>
                    <ul>
                        <li><a href="blog.html">Blog Masonry</a></li>
                        <li><a href="blog-single.html">Post Single</a></li>
                    </ul>
                </li>
                <li><a href="#">Pages</a>
                    <ul>
                        <li><a href="our-team.html">Our Team</a></li>
                        <li><a href="archives.html">Archives</a></li>
                        <li><a href="grids.html">Columns</a></li>
                        <li><a href="404.html">404 Page</a></li>
                    </ul>
                </li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </header> <!-- /.site-header -->
    <?php
    /*NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();*/
    ?>


    <?= $content ?>

</div>

<?php
    $script = <<< JS
        $(window).load(function() { 
            $('.loader-item').fadeOut(); 
            $('#pageloader').delay(350).fadeOut('slow'); 
            $('body').delay(350).css({'overflow-y':'visible'});
        })
JS;
  //  $this->registerJsFile('js/vendor/jquery-1.11.0.min.js',  ['position' => yii\web\View::POS_END]);
    $this->registerJs($script, yii\web\View::POS_END);
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
