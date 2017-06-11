<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 4/15/17
 * Time: 9:49 PM
 */

namespace app\modules\admin\models;

use amnah\yii2\user\models\Profile;
use amnah\yii2\user\models\Role;
use amnah\yii2\user\models\UserAuth;
use amnah\yii2\user\models\UserToken;

class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'status'], 'required'],
            [['role_id', 'status'], 'integer'],
            [['logged_in_at', 'created_at', 'updated_at', 'banned_at'], 'safe'],
            [['email', 'username', 'password', 'auth_key', 'access_token', 'logged_in_ip', 'created_ip', 'banned_reason'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::className(), 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'status' => 'Status',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
            'logged_in_ip' => 'Logged In Ip',
            'logged_in_at' => 'Logged In At',
            'created_ip' => 'Created Ip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'banned_at' => 'Banned At',
            'banned_reason' => 'Banned Reason',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBlogs()
    {
        return $this->hasMany(Blog::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAuths()
    {
        return $this->hasMany(UserAuth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserTokens()
    {
        return $this->hasMany(UserToken::className(), ['user_id' => 'id']);
    }

    /**
     * @return status dropdown list
     */
    public static function getStatusDropdownList()
    {
        return [1=>'待实现',2=>'待实现'];
    }


}