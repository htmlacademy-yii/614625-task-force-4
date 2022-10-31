<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Users;
use Yii\app\security;

class LoginForm extends Model
{
    public $email;
    public $password;
    public $user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['password', 'string', 'max' => 64],
            ['email', 'email'],
            [['password'], 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->user === null) {
            $this->user = Users::findOne(['email' => $this->email]);
        }
        return $this->user;
    }
}