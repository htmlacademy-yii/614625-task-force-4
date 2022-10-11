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
 * @property int $cities_id
 *
 * @property Cities $cities
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
            [['creation_time', 'name', 'longitude', 'latitude', 'cities_id'], 'required'],
            [['creation_time'], 'safe'],
            [['longitude', 'latitude'], 'number'],
            [['cities_id'], 'integer'],
            [['name'], 'string', 'max' => 122],
            [['name'], 'unique'],
            [['cities_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['cities_id' => 'id']],
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
            'cities_id' => 'Cities ID',
        ];
    }

    /**
     * Gets query for [[Cities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCities()
    {
        return $this->hasOne(Cities::class, ['id' => 'cities_id']);
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
