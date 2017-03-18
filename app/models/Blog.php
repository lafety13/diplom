<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $short_description
 * @property string $image
 * @property string $date
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_blog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'short_description', 'preview_image', 'date'], 'required'],
            [['short_description', 'date'], 'string'],
            [['title', 'preview_image'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'short_description' => 'Short Description',
            'preview_image' => 'Image',
            'date' => 'Date',
        ];
    }
    public static function getAllArticles()
    {
        return Blog::find()->all();
    }
    public static function getArticleById($id)
    {
        $article = Blog::findOne($id);

        if (empty($article)) {
            throw new NotFoundHttpException('Article not found');
        }
        return $article;
    }

    public static function count()
    {
        return Blog::count();
    }

}
