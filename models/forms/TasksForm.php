<?php 
namespace app\models\forms;

use Yii;
use app\models\Categories;
use app\models\Tasks;
use yii\base\Model;
use yii\db\ActiveQuery;

class TasksForm extends Model
{
    public $category = [];
    public $noExecutor = false;
    public $period;

    const ONE_HOUR = 1;
    const DAY = 24;
    const WEEK = 168;
    //получить просто таски
    public function getTasks(){
        $activeQuery = Tasks::find();
        $activeQuery->joinWith('location');
        $activeQuery->joinWith('category');
        $activeQuery->where(['status' => Tasks::STATUS_NEW]);
        return $activeQuery;
    }
    //получить отфильтрованные таски
    public function getFilterTasks(){
        $activeQuery = $this->getTasks();
        
    }

    public function attributeLabels()
    {
        return [
            'category' => 'Категории',
            'noExecutor' =>  'Без исполнителя',
            'period' => 'Период',
        ];
    }

    public function rules()
    {
        return [
            [
                ['category', 'each', 'rule' => ['exist', 'targetClass' => Categories::className(), 'targetAttribute' => ['category' => 'id']]],
                ['noExecutor', 'boolean'],
                ['period', 'in', 'range' => [self::ONE_HOUR, self::DAY, self::WEEK] ]
            ]
        ];
    }
}


