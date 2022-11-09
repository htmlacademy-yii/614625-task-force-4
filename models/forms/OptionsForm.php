<?php
namespace app\models\forms;

use app\models\Categories;
use app\models\Users;
use app\models\UserCategories;
use Yii;
use yii\base\Model;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\web\UploadedFile;

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
    private $filePath;
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

    public function loadToUser(): void
    {
        if (!$this->uploadFile() && $this->file) {
            throw new FileUploadException('Загрузить файл не удалось');
        }
        
        $user = Users::findOne(Yii::$app->user->id);
        $user->name = $this->login;
        $user->email = $this->email; 
        $user->bdate = $this->bdate;
        $user->phone = $this->phone;
        $user->telegram = $this->telegram;
        $user->description = $this->description;
        $user->avatar = $this->filePath;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!empty($this->userCategory)) {
                $this->loadUserCategory();
            }
            if (!$user->save()) {
                throw new Exception('Не удалось сохранить модель User');
            }
            $transaction->commit();
        } catch (Exception $exception) {
            $transaction->rollback();
            throw new Exception($exception->getMessage());
        }

    }

    public function loadUserCategory(): void
    {
        UserCategories::deleteByUser(Yii::$app->user->id);

        foreach ($this->userCategory as $category) {
            $userCategory = new UserCategories();
            $userCategory->user_id = Yii::$app->user->id;
            $userCategory->category_id = $category;
            $userCategory->save();
        }
    }

    private function uploadFile(): bool
    {
        if ($this->file && $this->validate()) {
            $newName = uniqid('upload') . '.' . $this->file->getExtension();
            $this->file->saveAs('@webroot/uploads/' . $newName);

            $this->filePath = $newName;
            return true;
        }
        return false;
    }
}