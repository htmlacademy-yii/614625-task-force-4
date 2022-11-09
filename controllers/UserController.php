<?php

namespace app\controllers;

use app\models\Users;
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\forms\PasswordForm;
use app\models\forms\OptionsForm;
use yii\web\UploadedFile;

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
        $passwordForm = new PasswordForm();

        if (Yii::$app->request->getIsPost()) {
            $passwordForm->load(Yii::$app->request->post());
           
            if ($passwordForm->validate()) {
                $passwordForm->loadToUser();
                
                return $this->redirect(['view', 'id' => Yii::$app->user->id]);
            }
        }

        return $this->render('password', ['model' => $passwordForm]);
    }

    public function actionOptions()
    {   
        $optionsForm = new OptionsForm();

        if (Yii::$app->request->getIsPost()) {
            $optionsForm->load(Yii::$app->request->post());
            $optionsForm->file = UploadedFile::getInstance($optionsForm, 'file');
  
            if ($optionsForm->validate()) {
                $optionsForm->loadToUser();

                return $this->redirect(['view', 'id' => Yii::$app->user->id]);
            }
        }

        return $this->render('options', ['model' => $optionsForm]);
    }

    public function actionOptionsmenu()
    {
        return $this->render('optionsmenu');
    }
}