<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property string $creation_time
 * @property int $task_id
 * @property int $user_id
 * @property string $text
 * @property int $price
 * @property int|null $is_rejected
 *
 * @property Tasks $task
 * @property Users $user
 */
class Responses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'task_id', 'user_id', 'text', 'price'], 'required'],
            [['creation_time'], 'safe'],
            [['task_id', 'user_id', 'price', 'is_rejected'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::class, 'targetAttribute' => ['task_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creation_time' => 'Creation Time',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'price' => 'Price',
            'is_rejected' => 'Is Rejected',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::class, ['id' => 'task_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::class, ['id' => 'user_id']);
    }
}
