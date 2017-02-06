<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->getView()->params['userName'] = $this->name;

            $result = \Yii::$app->mailer->compose([
                'html' => 'views/contactWithAdmin-html',
            ], ['body' => $this->body,
                'subject' => $this->subject,
                'email' => $this->email])
                ->setFrom([$this->email => $this->name])
                ->setTo($email)
                ->setSubject("FROM USER")
                ->send();

            Yii::$app->mailer->getView()->params['userName'] = null;

            return $result;
        }
       return false;
    }
}
