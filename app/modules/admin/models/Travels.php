<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 6/11/17
 * Time: 7:14 PM
 */

namespace app\modules\admin\models;


/**
 * This is the model class for table "oa_travels".
 *
 * @property integer $id
 * @property string $name
 * @property string $short_description
 * @property string $text
 * @property string $date
 * @property string $preview_image
 */
class Travels extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oa_travels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'short_description', 'text', 'date', 'preview_image'], 'required'],
            [['text'], 'string'],
            [['title'], 'string'],
            [['name'], 'string', 'max' => 100],
            [['short_description'], 'string', 'max' => 200],
            [['date'], 'string', 'max' => 50],
            [['preview_image'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'short_description' => 'Short Description',
            'text' => 'Text',
            'date' => 'Date',
            'title' => 'Title',
            'preview_image' => 'Preview Image',
        ];
    }

}
