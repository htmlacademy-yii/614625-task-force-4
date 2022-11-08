<?php

namespace app\controllers;

use Yii;
use yii\authclient\clients\VKontakte;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\Controller;
use GuzzleHttp\Client;

class LoginController extends Controller
{

    public function actionAuth()
    {
        $url = Yii::$app->authClientCollection->getClient("vkontakte")->buildAuthUrl();
        Yii::$app->getResponse()->redirect($url);
    }
    
}