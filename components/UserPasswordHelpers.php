<?php 
namespace app\components;

use app\models\Users;
use yii;

class UserPasswordHelpers
{
    public function loadToUser($passWord)
    {
        $user = Users::findOne(Yii::$app->user->id);
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($passWord);
        $user->save();
    }
}