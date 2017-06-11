<?php

namespace app\controllers;

use amnah\yii2\user\models\User;
use app\models\ContactForm;
use app\modules\admin\models\Comment;
use app\modules\admin\models\Travels;
use kartik\helpers\Html;
use Yii;
use app\common\Controller;
use yii\data\Pagination;
use yii\helpers\Url;
use app\modules\admin\models\Blog;

class SiteController extends Controller
{
    public $layout = 'column1';

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionBlog()
    {
        $query = Blog::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $articles = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('blog', [
            'articles' => $articles,
            'pages' => $pages,
        ]);

    }

    public function actionArticle($id)
    {
        $article = Blog::getArticleById($id);
        $comments = Comment::getCommentByBlogId($id);
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            Yii::$app->session->setFlash('commentFormSubmitted');
            return $this->refresh();
        }

        return $this->render('article', [
            'article' => $article,
            'model' => $model,
            'comments' => $comments
        ]);
    }

    public function actionTravels() {
        $query = Travels::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 9]);
        $articles = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('travels', [
            'articles' => $articles,
            'pages' => $pages,
        ]);

    }

    public function actionTravel($id)
    {
        $article = Travels::findOne($id);

        return $this->render('travel', [
            'article' => $article,
        ]);
    }
}
