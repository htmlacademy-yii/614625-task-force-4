<?php

namespace app\controllers;

use app\models\forms\TasksForm;
use Yii;
use app\models\Tasks;
use app\models\forms\TaskCreateForm;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use app\services\TaskCreateService;

class TasksController extends AuthController
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

    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        if (!$task) {
            throw new NotFoundHttpException("По указанному id задача не найдена");
        }

        return $this->render('view', ['task' => $task]);
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->getIdentity();
        if ($user->is_customer === 0) {
            return $this->redirect('/tasks');
        }

        $taskCreateForm = new TaskCreateForm();

        if (Yii::$app->request->getIsPost()) {
            
            $newTask = new Tasks();
            $taskCreateForm->load(Yii::$app->request->post());
            $newTask->customer_id = Yii::$app->user->identity->id; 
            $newTask->creation_time = date("Y-m-d H:i:s");
            $newTask->title = $taskCreateForm->name;
            $newTask->description = $taskCreateForm->description;
            $newTask->category_id = $taskCreateForm->category;
            $newTask->location_id = 1;
            $newTask->customer_id = $user->id;
            $newTask->status = 'new';
            $newTask->budget = $taskCreateForm->budget;
            $newTask->date_completion = $taskCreateForm->dateCompletion;

            if($newTask->validate()) {
                
                $newTask->taskFiles = UploadedFile::getInstances($taskCreateForm, 'files');    
                $newTask->save();

                $taskCreateServices = new TaskCreateService();
                $taskCreateServices->saveUploadFiles($newTask->taskFiles, $newTask->id);

                return $this->redirect('/tasks/view?id=' . $newTask->id);
            }
        }

        return $this->render('create', ['taskCreateForm' => $taskCreateForm]);
    }
}
