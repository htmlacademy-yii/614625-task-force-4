<?php

namespace app\controllers;

use app\models\Tasks;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex() {
        $activeQuery = Tasks::find();
        $activeQuery->joinWith('location');
        $activeQuery->joinWith('category');
        $activeQuery->where(['status'=> Tasks::STATUS_NEW]);
        $activeQuery->orderBy(['creation_time' => SORT_ASC]);
        $tasks = $activeQuery->all();
        return $this->render('task', ['tasks' => $tasks]);
    }

}