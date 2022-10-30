<?php

namespace app\controllers;

use app\models\forms\RegistrationForm;
use Yii;
use yii\web\Controller;
use yii\base\Exception; 

class RegistrationController extends Controller
{
    public function actionIndex()
    {
        $registrationForm = new RegistrationForm();
        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());
            if ($registrationForm->validate()){
                if (!$registrationForm->createUser()->save()) {
                    throw new Exception('Не удалось сохранить данные');
                }
                Yii::$app->response->redirect(['tasks']);
            }
        }
        return $this->render('registration', ['model' => $registrationForm]);
    }
}