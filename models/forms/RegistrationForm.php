<?php 
namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\Users;
use app\models\Cities;

class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $cityId;
    public $password;
    public $repeatPassword;
    public $isExecutor;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'email' => 'Email',
            'cityId' => 'Город',
            'password' => 'Пароль',
            'repeatPassword' => 'Повтор пароля',
            'isExecutor' => 'я собираюсь откликаться на заказы'
        ];
    }
}