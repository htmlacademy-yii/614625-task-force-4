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
            [['name', 'description', 'category'], 'required'],
            ['name', 'string', 'min' => 4, 'max' => 122],
            ['description', 'string', 'min' => 10,'max' => 255],
            [['dateCompletion'], 'compare', 'compareValue' => date('Y-m-d'),'operator' => '>', 'type' => 'date',
                'message' => 'Дата выполнения задания не может быть раньше текущей даты'],
            [['location'], 'string'],
            ['category', 'exist', 'targetClass' => Categories::class,'targetAttribute' => ['category' => 'id']],
            ['budget', 'integer', 'min' => 1],
            [['files'], 'file', 'skipOnEmpty' => true,'maxFiles' => 4,'checkExtensionByMimeType' => false],
        ];
    }
}