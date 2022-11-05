<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Tasks;
use app\models\Users;

class CompleteTaskForm extends Model
{
    public $task_id;
    public $customer_id;
    public $executor_id;
    public $text;
    public $stars;

    public function rules()
    {
        return [
            [['task_id', 'customer_id', 'executor_id', 'text', 'stars'], 'required'],
            ['customer_id', 'exist', 'targetClass' => Users::class, 'targetAttribute' => ['customer_id' => 'id']],
            ['executor_id', 'exist', 'targetClass' => Users::class, 'targetAttribute' => ['executor_id' => 'id']],
            ['text', 'string', 'min' => 10, 'max' => 256],
            [['task_id', 'customer_id', 'executor_id', 'stars'], 'integer'],
            ['task_id', 'exist', 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            
        ];
    }

    public function attributeLabels()
    {
        return [
            'task_id' => 'Задание',
            'customer_id' => 'Заказчик',
            'executor_id' => 'Исполнитель',
            'text' => 'Комментарий',
            'stars' => 'Оценка'
        ];
    }
}