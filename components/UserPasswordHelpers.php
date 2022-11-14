<?php 
namespace app\components;

use app\models\Users;
use yii;

class UserPasswordHelpers
{
    /**
     * Сохраняет изменненый пароль для пользователя
     * @param $password string пароль с формы
     * @return void
     */
    public function loadToUser($passWord) :void
    {
        $user = Users::findOne(Yii::$app->user->id);
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($passWord);
        $user->save();
    }
}