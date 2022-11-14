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
use app\services\UserCreateService;

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
        $service = new UserCreateService();
        $newUser = $service->createVk($userAttributes);
        Yii::$app->user->login($newUser);
        return $this->redirect('/tasks');
    }
}