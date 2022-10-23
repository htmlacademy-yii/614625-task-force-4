<?php 
namespace app\models\forms;

use Yii;
use app\models\Categories;
use app\models\Tasks;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Expression;

class TasksForm extends Model
{
    public $category = [];
    public $noExecutor = false;
    public $period;

    const ONE_HOUR = 1;
    const DAY = 24;
    const WEEK = 168;
    
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

        //добавить фильтрацию по категории

        //добавить фильтрацию по периоду

        //добавить фитрацию по исполнителю
        
    }

    public function attributeLabels()
    {
        return [
            'category' => 'Категории',
            'noExecutor' =>  'Без исполнителя',
            'period' => 'Период',
        ];
    }

    public function choosePeriod($activeQuery){

    }

    public function periodAttributeLabels(): array
    {
        return [self::ONE_HOUR => '1 час', self::DAY => '24 часа', self::WEEK => 'неделя'];
    }

    public function rules()
    {   
        return [
            ['category', 'each', 'rule' => ['exist', 'targetClass' => Categories::class, 'targetAttribute' => ['category' => 'id']]],
            ['noExecutor', 'boolean'],
            ['period', 'in', 'range' => [self::ONE_HOUR, self::DAY, self::WEEK] ]
        ];
    }
}


