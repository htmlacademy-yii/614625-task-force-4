<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $creation_time
 * @property string $name
 * @property string $symbol_code
 *
 * @property Tasks[] $tasks
 * @property UserCategories[] $userCategories
 */
class Categories extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'name', 'symbol_code'], 'required'],
            [['creation_time'], 'safe'],
            [['name'], 'string', 'max' => 64],
            [['symbol_code'], 'string', 'max' => 122],
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
            'symbol_code' => 'Symbol Code',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::class, ['category_id' => 'id']);
    }

    /**
     * Получает доступные категории
     * @return array
     */
    public static function getCategoriesList() :array
    {
        $data = static::find()
            ->select(['id', 'name'])
            ->orderBy('id')
            ->asArray()
            ->all();
        return ArrayHelper::map($data, 'id', 'name');
    }
}
