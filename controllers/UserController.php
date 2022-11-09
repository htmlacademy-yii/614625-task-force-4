<?php

namespace app\controllers;

use app\models\Users;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserController extends AuthController
{
    public function actionView($id)
    {
        $user = Users::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException("Юзер с ID $id не найден");
        }
        return $this->render('view', ['user' => $user]);
    }

    public function actionPassword()
    {
        return $this->render('password');
    }

    public function actionOptions()
    {
        return $this->render('options');
    }

    public function actionOptionsmenu()
    {
        return $this->render('optionsmenu');
    }
}