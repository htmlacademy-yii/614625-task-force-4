<?php
namespace app\models\forms;

use yii\base\Model;
use app\models\Categories;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $location;
    public $budget;
    public $dateCompletion;
    public $files;

    public function attributeLabels()
    {
        return [
            'name' => 'Опишите суть работы',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'location' => 'Локация',
            'budget' => 'Бюджет',
            'dateCompletion' => 'Срок исполнения',
            'files' => 'Файлы'
        ];
    }

    public function rules()
    {
        return [

        ];
    }
}