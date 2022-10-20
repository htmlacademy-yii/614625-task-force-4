<?php

namespace app\controllers;

use app\models\forms\TasksForm;
use Yii;
use app\models\Tasks;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex() {
        $taskForm = new TasksForm();
        $tasks = $taskForm->getTasks()->all();

        if (Yii::$app->request->getIsPost()){
            //echo 'yes';
            var_dump($_POST);
            exit;
        }
        return $this->render('task', ['tasks' => $tasks]);
    }
}
