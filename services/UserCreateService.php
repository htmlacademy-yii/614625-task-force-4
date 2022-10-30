<?php
namespace app\services;

use yii;
use app\models\Users;

class UserCreateService {
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
}