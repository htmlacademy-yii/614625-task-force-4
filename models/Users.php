<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $creation_time
 * @property string $name
 * @property string $email
 * @property int $city_id
 * @property string $password
 * @property int|null $is_customer
 * @property string $telegram
 * @property string $phone
 * @property string $avatar
 *
 * @property Cities $city
 * @property Responses[] $responses
 * @property Reviews[] $reviews
 * @property Tasks[] $tasks
 * @property Tasks[] $tasks0
 * @property UserCategories[] $userCategories
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation_time', 'name', 'email', 'city_id', 'password', 'telegram', 'phone', 'avatar'], 'required'],
            [['creation_time'], 'safe'],
            [['city_id', 'is_customer'], 'integer'],
            [['name'], 'string', 'max' => 122],
            [['email', 'password', 'telegram', 'phone', 'avatar'], 'string', 'max' => 64],
            [['email'], 'unique'],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::class, 'targetAttribute' => ['city_id' => 'id']],
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
            'email' => 'Email',
            'city_id' => 'City ID',
            'password' => 'Password',
            'is_customer' => 'Is Customer',
            'telegram' => 'Telegram',
            'phone' => 'Phone',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::class, ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Tasks::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Tasks::class, ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[UserCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCategories()
    {
        return $this->hasMany(UserCategories::class, ['user_id' => 'id']);
    }
}
