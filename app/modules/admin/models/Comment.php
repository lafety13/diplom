<?php

namespace app\modules\admin\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "oa_comment".
 *
 * @property integer $id
 * @property string $user_name
 * @property string $email
 * @property string $comment
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'email', 'comment'], 'required'],
            [['article_id'], 'integer'],
            [['user_name', 'email'], 'string', 'max' => 100],
            [['comment'], 'string', 'max' => 250],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Blog::className(), 'targetAttribute' => ['article_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'email' => 'Email',
            'comment' => 'Comment',
            'article_id' => 'Article ID',
        ];
    }

    /**
     * @return status dropdown list
     */
    public static function getStatusDropdownList()
    {
        return [1=>'',2=>''];
    }

    public static function getCommentByBlogId($id)
    {
        $comments = Comment::find()->where(["article_id" => $id])->all();

        return $comments;
    }

    public static function getTotalCommentsOfArticle($id)
    {
        $count = Comment::find()->where(["article_id" => $id])->count();

        return $count;
    }

}