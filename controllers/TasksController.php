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
            $taskForm->load(Yii::$app->request->post());
            if (!$taskForm->validate()) {
                $errors = $this->getErrors();
            } else {
                $tasks = $taskForm->getFilterTasks();
            }
        }
        return $this->render('task', ['tasks' => $tasks, 'model' => $taskForm]);
    }
}
