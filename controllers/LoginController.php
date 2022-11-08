<?php

namespace app\controllers;

use Yii;
use yii\authclient\clients\VKontakte;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use GuzzleHttp\Client;
use app\models\Users;
use app\models\Cities;

class LoginController extends Controller
{

    public function actionAuth()
    {
        $url = Yii::$app->authClientCollection->getClient("vkontakte")->buildAuthUrl();
        Yii::$app->getResponse()->redirect($url);
    }

    public function actionVk()
    {
        $code = Yii::$app->request->get('code');
        $vkClient = Yii::$app->authClientCollection->getClient("vkontakte");
        $accessToken = $vkClient->fetchAccessToken($code);
        $userAttributes = $vkClient->getUserAttributes();

        $user = Users::findOne(['vk_id' => $userAttributes['user_id']]);
        if ($user){
            Yii::$app->user->login($user);
            return $this->redirect('/tasks');
        }
        $newUser = new Users();
        $newUser->creation_time = date("Y-m-d H:i:s");
        $newUser->name = $userAttributes["first_name"] . ' ' . $userAttributes["last_name"];
        $newUser->email = $userAttributes["email"];

        $city = Cities::findOne(['name' => $userAttributes["city"]['title']]);
        $newUser->city_id = $city->id;
        
        $newUser->password = 'asdasdsa';
        $newUser->is_customer = 1;
        $newUser->vk_id = $userAttributes["user_id"];
        $newUser->save();
        Yii::$app->user->login($newUser);
        return $this->redirect('/tasks');
    }
}