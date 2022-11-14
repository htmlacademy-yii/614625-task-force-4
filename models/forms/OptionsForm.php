<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\web\UploadedFile;
use app\models\Categories;

class OptionsForm extends Model
{
    public $login;
    public $email;
    public $bdate;
    public $phone;
    public $telegram;
    public $description;
    public $userCategory;
    public $file;
    public $filePath;
    const PHONE_NUM_LENGTH = 11;
    const TELEGRAM_LENGTH = 64;

    public function rules(): array
    {
        return [
            [['login', 'email'], 'required'],
            [['email'], 'email'],
            [['description'], 'string'],
            [['phone'], 'string', 'length' => [self::PHONE_NUM_LENGTH, self::PHONE_NUM_LENGTH]],
            [['telegram'], 'string', 'length' => [0, self::TELEGRAM_LENGTH]],
            [['bdate'], 'date', 'format' => 'php:Y-m-d'],
            [['userCategory'], 'each', 'rule' => ['exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['userCategory' => 'id']]],
            [['file'], 'file'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'login' => 'Ваше имя',
            'email' => 'Email',
            'bdate' => 'День рождения',
            'phone' => 'Номер телефона',
            'telegram' => 'Telegram',
            'description' => 'Информация о себе',
            'userCategory' => 'Выбор специализации',
            'file' => 'Сменить аватар'
        ];
    }

}