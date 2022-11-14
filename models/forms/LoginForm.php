<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Users;

class LoginForm extends Model
{
    public $email;
    public $password;
    private $user;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
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

    /**
     * Сравнивает пароль введенный пользователем с хэшем пароля, хранящимся в БД
     * @param $attribute
     * @return void
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !\Yii::$app->security->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, 'Неправильный email или пароль');
            }
        }
    }

     /**
     * Возвращает Объект пользователя, если находит
     * @return User|null Пользователь или его отсутствие
     */
    public function getUser()
    {
        if ($this->user === null) {
            $this->user = Users::findOne(['email' => $this->email]);
        }
        return $this->user;
    }
}