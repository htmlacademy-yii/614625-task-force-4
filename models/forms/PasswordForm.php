<?php
namespace app\models\forms;

use Yii;
use yii\base\Model;
use app\models\Users;

class PasswordForm extends Model
{
    public $oldPassword;
    public $newPassword;
    public $repeatPassword;

    public function attributeLabels()
    {
        return [
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'repeatPassword' => 'Повторите пароль'
        ];
    }

    public function rules()
    {
        return [
            [['oldPassword', 'newPassword', 'repeatPassword'], 'required'],
            [['newPassword', 'repeatPassword'], 'string', 'max' => 64],
            [['repeatPassword'], 'compare', 'compareAttribute' => 'newPassword'],
            [['oldPassword'], 'validatePassword']
        ];
    }

    /**
     * Сравнивает пароль введенный пользователем с паролем, хранящимся в БД
     * @param $attribute
     * @return void
     */
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = Users::findOne(['id' => Yii::$app->user->id]);
            
            if (!$user || !\Yii::$app->security->validatePassword($this->oldPassword, $user->password)) {
                $this->addError($attribute, 'Неверный пароль');
            }
        }
    }
}