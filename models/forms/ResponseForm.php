<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Tasks;

class ResponseForm extends Model
{
    public $task_id;
    public $price;
    public $text;

    public function rules()
    {
        return [
            [['task_id', 'price', 'text'], 'required'],
            [['price'], 'compare', 'compareValue' => 0, 'operator' => '>', 'type' => 'number'],
            ['text', 'string', 'min' => 10, 'max' => 255],
            ['task_id', 'exist', 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
        ];
    }
    
    public function attributeLabels(): array
    {
        return [
            'task_id' => 'Задание',
            'price' => 'Стоимость',
            'text' => 'Комментарий'
        ];
    }
}