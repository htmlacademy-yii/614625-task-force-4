<?php

namespace app\controllers;

use app\models\forms\TasksForm;
use Yii;
use app\models\Tasks;
use app\models\forms\TaskCreateForm;
use yii\web\Controller;
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
            
            $taskCreateForm->load(Yii::$app->request->post());
            $taskCreateService = new taskCreateService();
            $taskCreateService->create($taskCreateForm);
        }

        return $this->render('create', ['taskCreateForm' => $taskCreateForm]);
    }

    //статус отклика меняет на принят 
    public function actionSubmit()
    {

    }

    //новый отклик на задание
    public function actionAccept()
    {

    }

    //меняет статус отклика на отклонен по идентификатору
    public function actionCancelr()
    {

    }

    //меняет статус задания на отменноно и отклоняет все отклики на него
    public function actionCancelt()
    {

    }

    //меняет статус задания на выполнено
    public function actionEnd(){

    }

    //меняет статус задания на провалено и отлоняет все отклики на него
    public function actionFail(){
        echo 'fail';
        exit;
    }
}
