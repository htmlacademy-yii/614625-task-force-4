<?php
namespace TaskForce;

use app\models\Tasks;
use app\models\Users;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

class TaskFilter
{
    public string $type;
    public int $userId;

    public function __construct(string $type, int $userId)
    {
        $this->userId =$userId;
        $this->type = $type;
    }

    public function getFilteredCustomerTasks()
    {
        $taskQuery = Tasks::find()
            ->joinWith('location')
            ->andFilterWhere(['customer_id' => $this->userId]);

        switch ($this->type) {
            case Tasks::STATUS_NEW:
                $taskQuery->andFilterWhere(['status' => Tasks::STATUS_NEW])->andFilterWhere(['executor_id' => null]);
                break;
            case Tasks::STATUS_WORKING:
                $taskQuery->andFilterWhere(['status' => Tasks::STATUS_WORKING]);
                break;
            case Tasks::STATUS_COMPLETED:
                $taskQuery->andFilterWhere(['in', 'status', [Tasks::STATUS_COMPLETED, Tasks::STATUS_CANCELED, Tasks::STATUS_FAILED]]);
                break;
        }
        return $taskQuery;
    }

    public function getFilteredExecutorTasks()
    {
        $taskQuery = Tasks::find()
            ->joinWith('location')
            ->andFilterWhere(['executor_id' => $this->userId]);

        switch ($this->type) {
            case Tasks::STATUS_WORKING:
                $taskQuery->andFilterWhere(['status' => Tasks::STATUS_WORKING]);
                break;
            case Tasks::STATUS_FAILED:
                $taskQuery->andFilterWhere(['status' => Tasks::STATUS_WORKING])->andFilterWhere(['<', 'date_completion', new Expression('NOW()')]);
                break;
            case Tasks::STATUS_COMPLETED:
                $taskQuery->andFilterWhere(['in', 'status', [Tasks::STATUS_COMPLETED, Tasks::STATUS_FAILED]]);
                break;
        }
        return $taskQuery;
    }
}