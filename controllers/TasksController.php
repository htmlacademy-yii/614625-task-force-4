<?php
namespace app\controllers;

use app\models\forms\TasksForm;
use Yii;
use app\models\Tasks;
use app\models\forms\TaskCreateForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\services\TaskCreateService;
use app\models\forms\CompleteTaskForm;
use app\models\forms\ResponseForm;
use app\models\Responses;
use app\models\Reviews;

class TasksController extends AuthController
{
    public function actionIndex() {
        $taskForm = new TasksForm();
        $tasks = new ActiveDataProvider([
            'query' => $taskForm->getTasks(),
            'pagination' => ['pageSize' => Yii::$app->params['pageSize']],
        ]);

        if (Yii::$app->request->getIsPost()){
            $taskForm->load(Yii::$app->request->post());
            if (!$taskForm->validate()) {
                $errors = $this->getErrors();
            } else {
                $tasks = new ActiveDataProvider([
                    'query' => $taskForm->getFilterTasks(),
                    'pagination' => ['pageSize' => Yii::$app->params['pageSize']],
                ]);
            }
        }
        return $this->render('task', ['tasks' => $tasks, 'model' => $taskForm]);
    }

    public function actionView($id)
    {
        $task = Tasks::findOne($id);

        $completeTaskForm = new CompleteTaskForm();
        $responseForm = new ResponseForm();

        if (!$task) {
            throw new NotFoundHttpException("По указанному id задача не найдена");
        }

        return $this->render('view', [
            'task' => $task,
            'CompleteTaskForm' => $completeTaskForm,
            'ResponseForm' => $responseForm
        ]);
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

    public function actionMy()
    {   
        $taskForm = new TasksForm();
        if(Yii::$app->user->identity->is_customer === 1){
            $tasks = new ActiveDataProvider([
                'query' => $taskForm->getMyCustomerTasks(Yii::$app->user->id),
                'pagination' => ['pageSize' => Yii::$app->params['pageSize']],
            ]);
        }
        if(Yii::$app->user->identity->is_customer !== 1){
            $tasks = new ActiveDataProvider([
                'query' => $taskForm->getMyExecutorTasks(Yii::$app->user->id),
                'pagination' => ['pageSize' => Yii::$app->params['pageSize']],
            ]);
        }
    
        return $this->render('my', ['tasks' => $tasks]);
    }

    //статус отклика меняет на принят 
    public function actionSubmit($id, $responseId)
    {   
        $response = Responses::findOne($responseId);
        $task = Tasks::findOne($id);
        $task->status = Tasks::STATUS_WORKING;
        $task->executor_id = $response->user_id;
        $task->update();
        return $this->redirect(['tasks/view', 'id' => $id]);
    }

    //новый отклик на задание
    public function actionAccept($id)
    {
        $responseForm = new ResponseForm();
        $responseForm->load(Yii::$app->request->post());
        if ($responseForm->validate()) {
            $response = new Responses();
            $response->creation_time = date('Y-m-d H:i:s');
            $response->task_id = $id;
            $response->user_id = Yii::$app->user->identity->id;
            $response->text = $responseForm->text;
            $response->price = $responseForm->price;
            $response->save();
            return $this->redirect(['tasks/view', 'id' => $id]);
        }
    }

    //меняет статус отклика на отклонен по идентификатору
    public function actionCancelr($id,$responseId)
    {   
        $response = Responses::findOne($responseId);  
        $response->is_rejected = 1;      
        $response->update();

        return $this->redirect(['tasks/view', 'id' => $id]);
    }

    //меняет статус задания на отменено и отклоняет все отклики на него
    public function actionCancelt($id)
    {
        $task = Tasks::findOne($id);
        $task->status = Tasks::STATUS_CANCELED;
        $task->update();
        foreach ($task->responses as $response){
            $response->is_rejected = 1;
            $response->update();
        }
        return $this->redirect('/tasks');
    }

    //меняет статус задания на выполнено
    public function actionComplete($id){

        $completeTaskForm = new CompleteTaskForm();
        $completeTaskForm->load(Yii::$app->request->post());
        if ($completeTaskForm->validate()){
            $task = Tasks::findOne($id);
            $task->status = Tasks::STATUS_COMPLETED;
            $task->update();

            $review = new Reviews;
            $review->creation_time = date('Y-m-d H:i:s');
            $review->task_id = $id;
            $review->stars = $completeTaskForm->stars;
            $review->user_id = $completeTaskForm->executor_id;
            $review->text = $completeTaskForm->text;
            $review->save();

            return $this->redirect(['tasks/view', 'id' => $id]);
        }

    }

    //меняет статус задания на провалено
    public function actionFail( $id){
        $task = Tasks::findOne($id);
        $task->status = Tasks::STATUS_FAILED;
        $task->update();
        return $this->redirect('/tasks');
    }
}
