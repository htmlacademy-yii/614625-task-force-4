<?php
namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\TaskFiles;
use app\models\Files;
use yii\web\UploadedFile;
use app\models\Locations;
use app\models\Cities;
use app\models\Responses;
use app\models\Reviews;

class TaskCreateService
{
    private $path = 'uploads';

    /**
     * Загружает файлы на сервер
     * @param $files array массив с файлами
     * @return array $uploadFiles
     */
    private function serviceUploadFiles($files)
    {
        $uploadFiles = [];

        foreach ($files as $key => $file) {
            $fileName = $file->name;
            $fileServerName = uniqid($file->baseName). '.' . $file->extension;

            if (!is_dir($this->path)) {
                mkdir($this->path);
            }

            $file->saveAs($this->path . '/' . $fileServerName);

            $uploadFiles[$key] = ['name' => $fileName, 'path' =>  $fileServerName];
        }

        return $uploadFiles;
    }

    /**
     * Сохраняет файлы задания
     * @param $files array массив с файлами
     * @param $taskId int задачи
     * @return void
     */
    private function serviceSaveFiles($files, $taskId)
    {
        foreach ($files as $file) {
            $fileObject = new Files();
            $fileObject->creation_time = date("Y-m-d H:i:s");
            $fileObject->name = $file['name'];
            $fileObject->path = '/uploads/' . $file['path'];
            $fileObject->save();

            $taskFile = new TaskFiles();
            $taskFile->task_id = $taskId;
            $taskFile->file_id = $fileObject->id;
            $taskFile->save();

        }
    }

    /**
     * Создает задание
     * @param $taskCreateForm объект taskCreateForm
     * @return void
     */
    public function create($taskCreateForm)
    {
        $newTask = new Tasks();
        $newTask->customer_id = Yii::$app->user->identity->id; 
        $newTask->creation_time = date("Y-m-d H:i:s");
        $newTask->title = $taskCreateForm->name;
        $newTask->description = $taskCreateForm->description;
        $newTask->category_id = $taskCreateForm->category;

        $user = Yii::$app->user->getIdentity();

        $location = new Locations();
        $location->creation_time = date("Y-m-d H:i:s");
        $city = Cities::findOne($user->city_id);
        $location->name = $this->getNameLocation($city->name);
        $location->longitude = $city->longitude;
        $location->latitude = $city->latitude;

        if($taskCreateForm->location){
            $location->name = $this->getNameLocation($taskCreateForm->location);
            $location->longitude = $this->getLong($taskCreateForm->location);
            $location->latitude = $this->getLat($taskCreateForm->location);
        }
        $location->cities_id = $user->city_id;

        $checkLocation = Locations::findOne(['name' => $location->name]);
        if($checkLocation){
            $newTask->location_id = $checkLocation->id;
        } else {
            $location->save();
            $newTask->location_id = $location->id;
        };

        $newTask->customer_id = $user->id;
        $newTask->customer_id = $user->id;
        $newTask->status = 'new';
        $newTask->budget = 0;
        if($taskCreateForm->budget){
            $newTask->budget = $taskCreateForm->budget;
        }
        $newTask->date_completion = date("Y-m-d H:i:s");
        if($taskCreateForm->dateCompletion){
            $newTask->date_completion = $taskCreateForm->dateCompletion;
        }
        
        if($newTask->validate()) {
            
            $newTask->taskFiles = UploadedFile::getInstances($taskCreateForm, 'files');    
            $newTask->save();

            $taskCreateServices = new TaskCreateService();
            $taskCreateServices->saveUploadFiles($newTask->taskFiles, $newTask->id);

            Yii::$app->response->redirect('/tasks/view?id=' . $newTask->id);

        }
    }

    /**
     * Полная загрузка файлов на сервер и в бд
     * @param $files array массив с файлами
     * @param $taskId int задачи
     * @return function
     */
    public function saveUploadFiles($files, $task_id) 
    {
        return $this->serviceSaveFiles($this->serviceUploadFiles($files), $task_id);
    }

    /**
     * Создает отклик
     * @param id int пользователя
     * @param $responseForm объект responseForm
     * @return void
     */
    public function createResponse($id, $responseForm)
    {
        $response = new Responses();
        $response->creation_time = date('Y-m-d H:i:s');
        $response->task_id = $id;
        $response->user_id = Yii::$app->user->identity->id;
        $response->text = $responseForm->text;
        $response->price = $responseForm->price;
        return $response->save();
    }

    /**
     * Создает отзыв
     * @param id int пользователя
     * @param $completeTaskForm объект completeTaskForm
     * @return void
     */
    public function createReview($id, $completeTaskForm)
    {
        $review = new Reviews;
        $review->creation_time = date('Y-m-d H:i:s');
        $review->task_id = $id;
        $review->stars = $completeTaskForm->stars;
        $review->user_id = $completeTaskForm->executor_id;
        $review->text = $completeTaskForm->text;
        return $review->save();
    }

    /**
     * Получает longitude локации
     * @param $location строка с локации с формы
     * @return decimal
     */
    private function getLong($location)
    {
        return Yii::$app->geocoder->getLong($location);
    }

    /**
     * Получает latutude локации
     * @param $location строка с локации с формы
     * @return decimal
     */
    private function getLat($location)
    {
        return Yii::$app->geocoder->getLat($location);
    }

    /**
     * Получает адрес локации
     * @param $location строка с локации с формы
     * @return string
     */
    private function getNameLocation($location)
    {
        return Yii::$app->geocoder->getAddress($location);
    }

}