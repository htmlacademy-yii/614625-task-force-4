<?php
namespace app\services;

use yii;
use app\models\Users;
use app\models\Cities;

class UserCreateService {

    /**
     * Создает пользователя с формы регистрации
     * @param $registrationForm объект registrationForm
     * @return void
     */
    public function create($registrationForm){
        $user = new Users;
        $user->creation_time = date('Y-m-d G:i:s');
        $user->name = $registrationForm->name;
        $user->email = $registrationForm->email;
        $user->city_id = $registrationForm->cityId;
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($registrationForm->password);
        $user->is_customer = 1;
        if($registrationForm->isExecutor){
            $user->is_customer = 0;
        }
        return $user->save();
    }

    /**
     * Создает пользователя через вк 
     * @param $userAttributes массив с данными пользователя
     * @return Users
     */
    public function createVk($userAttributes){
        $newUser = new Users();
        $newUser->creation_time = date("Y-m-d H:i:s");
        $newUser->name = $userAttributes["first_name"] . ' ' . $userAttributes["last_name"];
        $newUser->email = $userAttributes["email"];

        $city = Cities::findOne(['name' => $userAttributes["city"]['title']]);
        $newUser->city_id = $city->id;
        
        $newUser->password = Yii::$app->getSecurity()->generatePasswordHash('asd');
        $newUser->is_customer = 1;
        $newUser->vk_id = $userAttributes["user_id"];
        $newUser->save();
        return $newUser;
    }
}