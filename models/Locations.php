<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "locations".
 *
 * @property int $id
 * @property string $creation_time
 * @property string $name
 * @property float $longitude
 * @property float $latitude
 *
 * @property Tasks[] $tasks
 */
class Locations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'locations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'name', 'longitude', 'latitude'], 'required'],
            [['creation_time'], 'safe'],
            [['longitude', 'latitude'], 'number'],
            [['name'], 'string', 'max' => 122],
            [['name'], 'unique'],
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
            'name' => 'Name',
            'longitude' => 'Longitude',
            'latitude' => 'Latitude',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['location_id' => 'id']);
    }
}
