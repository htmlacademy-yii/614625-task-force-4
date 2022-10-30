<?php

namespace app\controllers;

use app\models\forms\RegistrationForm;
use Yii;
use yii\web\Controller;
use yii\base\Exception; 
use app\services\UserCreateService;

class RegistrationController extends Controller
{
    public function actionIndex()
    {
        $registrationForm = new RegistrationForm();
        if (Yii::$app->request->getIsPost()) {
            $registrationForm->load(Yii::$app->request->post());
            if ($registrationForm->validate()){
                $service = new UserCreateService();
                if (!$service->create($registrationForm)) {
                    throw new Exception('Не удалось сохранить данные');
                }
                Yii::$app->response->redirect(['tasks']);
            }
        }
        return $this->render('registration', ['model' => $registrationForm]);
    }
}