<?php
namespace app\services;

use Yii;
use app\models\Tasks;
use app\models\TaskFiles;
use app\models\Files;
use yii\web\UploadedFile;

class TaskCreateService
{
    private $path = 'uploads';

    private function serviceUploadFiles($files){
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

    public function create($taskCreateForm)
    {
        $newTask = new Tasks();
        $newTask->customer_id = Yii::$app->user->identity->id; 
        $newTask->creation_time = date("Y-m-d H:i:s");
        $newTask->title = $taskCreateForm->name;
        $newTask->description = $taskCreateForm->description;
        $newTask->category_id = $taskCreateForm->category;
        $newTask->location_id = 1;
        $user = Yii::$app->user->getIdentity();
        $newTask->customer_id = $user->id;
        $newTask->status = 'new';
        $newTask->budget = $taskCreateForm->budget;
        $newTask->date_completion = $taskCreateForm->dateCompletion;

        if($newTask->validate()) {
            
            $newTask->taskFiles = UploadedFile::getInstances($taskCreateForm, 'files');    
            $newTask->save();

            $taskCreateServices = new TaskCreateService();
            $taskCreateServices->saveUploadFiles($newTask->taskFiles, $newTask->id);

            Yii::$app->response->redirect('/tasks/view?id=' . $newTask->id);

        }
    }

    public function saveUploadFiles($files, $task_id) {
        return $this->serviceSaveFiles($this->serviceUploadFiles($files), $task_id);
    }
}