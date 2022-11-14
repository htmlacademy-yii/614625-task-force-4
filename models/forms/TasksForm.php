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
    
    /**
     * Возвращает запрос на новые задания 
     * @return ActiveQuery
     */
    public function getTasks()
    {
        $activeQuery = Tasks::find();
        $activeQuery->joinWith('location');
        $activeQuery->joinWith('category');
        $activeQuery->where(['status' => Tasks::STATUS_NEW]);
        return $activeQuery;
    }

    /**
     * Возвращает запрос на новые задания с учетом фильтрации
     * @return ActiveQuery
     */
    public function getFilterTasks()
    {
        $activeQuery = $this->getTasks();

        if ($this->noExecutor) {
            $activeQuery->andWhere(['executor_id' => null]);
        }
        if (isset($this->category)) {
            $activeQuery->andFilterWhere(['category_id' => $this->category]);
        }
        if ($this->period) {
            $this->choosePeriod($activeQuery);
        }

        return $activeQuery; 
    }

    public function attributeLabels()
    {
        return [
            'category' => 'Категории',
            'noExecutor' =>  'Без исполнителя',
            'period' => 'Период',
        ];
    }

    /**
     * Возвращает условие фильтрации по времени
     * @return ActiveQuery
     */
    private function choosePeriod($activeQuery)
    {
        switch ($this->period) {
            case self::ONE_HOUR:
                return $activeQuery->andFilterWhere(['>', 'tasks.creation_time', new Expression('CURRENT_TIMESTAMP() - INTERVAL 1 HOUR')]);
            case self::DAY:
                return $activeQuery->andFilterWhere(['>', 'tasks.creation_time', new Expression('CURRENT_TIMESTAMP() - INTERVAL 24 HOUR')]);
            case self::WEEK:
                return $activeQuery->andFilterWhere(['>', 'tasks.creation_time', new Expression('CURRENT_TIMESTAMP() - INTERVAL 168 HOUR')]);
        }
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


