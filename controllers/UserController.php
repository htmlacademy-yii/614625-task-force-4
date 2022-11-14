<?php

namespace app\controllers;

use app\models\Users;
use yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\forms\PasswordForm;
use app\models\forms\OptionsForm;
use yii\web\UploadedFile;
use app\components\UserPasswordHelpers;
use app\components\UserOptionsHelpers;

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
                $userHelpers = new UserPasswordHelpers();
                $userHelpers->loadToUser($passwordForm->newPassword);
                
                return $this->redirect(['view', 'id' => Yii::$app->user->id]);
            }
        }

        return $this->render('password', ['model' => $passwordForm]);
    }

    public function actionOptions()
    {   
        $optionsForm = new OptionsForm();
        $user = Users::findOne(Yii::$app->user->id);
        
        if (Yii::$app->request->getIsPost()) {
            $optionsForm->load(Yii::$app->request->post());
            $optionsForm->file = UploadedFile::getInstance($optionsForm, 'file');
  
            if ($optionsForm->validate()) {

                $userHelpers = new UserOptionsHelpers();
                $userHelpers->loadToUser($optionsForm);

                return $this->redirect(['view', 'id' => Yii::$app->user->id]);
            }
        }

        return $this->render('options', ['model' => $optionsForm, 'user' => $user]);
    }

    public function actionOptionsmenu()
    {
        return $this->render('optionsmenu');
    }
}