<?php

namespace app\controllers;

use Yii;
use yii\authclient\clients\VKontakte;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use GuzzleHttp\Client;
use app\models\Users;

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

        //далее проверяем если такой пользователь есть, то авторизуем

        //иначе сохраняем и авторизуем

        print_r('<pre>');
        var_dump($userAttributes);
        print_r('</pre>');
        exit;



    }

}