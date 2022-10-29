<?php

namespace app\controllers;

use app\models\Users;
use app\models\forms\RegistrationForm;
use TaskForce\exceptions\ModelSaveException;
use Yii;
use yii\web\Controller;

class RegistrationController extends Controller
{
    public function actionIndex()
    {
        $registrationForm = new RegistrationForm();
        return $this->render('registration', ['model' => $registrationForm]);
    }
}