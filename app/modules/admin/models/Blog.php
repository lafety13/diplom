<?php
/**
 * This is the model class for table "oa_blog".
 *
 * @property integer $id
 * @property string $title
 * @property string $short_description
 * @property string $text
 * @property integer $author_id
 * @property string $date
 * @property string $preview_image
 * @property string $tags
 *
 * @property User $author
 */

namespace app\modules\admin\models;

use Yii;
use yii\web\NotFoundHttpException;

class Blog extends \yii\db\ActiveRecord
{
    private $module;

    public function init()
    {
        if (!$this->module) {
            $this->module = Yii::$app->getModule("user");
        }
    }
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
            [['title', 'short_description', 'text', 'author_id', 'date', 'preview_image', 'tags'], 'required'],
            [['text'], 'string'],
            [['author_id'], 'integer'],
            [['date'], 'safe'],
            [['title', 'short_description', 'preview_image', 'tags'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
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
            'text' => 'Text',
            'author_id' => 'Author ID',
            'date' => 'Date',
            'preview_image' => 'Preview Image',
            'tags' => 'Tags',
        ];
    }


    public static function getAuthor($id)
    {
        return User::find()->where(['id' => $id])->one();

//        return User::find()->where(['id' => 1]);

    }

    /**
     * @return status dropdown list
     */
    public static function getStatusDropdownList()
    {
        return [1=>'1',2=>'2'];
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

}