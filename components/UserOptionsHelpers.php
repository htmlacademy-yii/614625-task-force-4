<?php 
namespace app\components;

use app\models\Users;
use yii;
use app\models\Categories;
use app\models\UserCategories;

class UserOptionsHelpers
{

    public function loadToUser($optionsForm): void
    {
        if (!$this->uploadFile($optionsForm) && $optionsForm->file) {
            throw new FileUploadException('Загрузить файл не удалось');
        }
        
        $user = Users::findOne(Yii::$app->user->id);
        $user->name = $optionsForm->login;
        $user->email = $optionsForm->email; 
        $user->bdate = $optionsForm->bdate;
        $user->phone = $optionsForm->phone;
        $user->telegram = $optionsForm->telegram;
        $user->description = $optionsForm->description;
        if($optionsForm->filePath) {
            $user->avatar = $optionsForm->filePath;
        }
        

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!empty($optionsForm->userCategory)) {
                $this->loadUserCategory($optionsForm);
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

    public function loadUserCategory($optionsForm): void
    {
        UserCategories::deleteByUser(Yii::$app->user->id);

        foreach ($optionsForm->userCategory as $category) {
            $userCategory = new UserCategories();
            $userCategory->user_id = Yii::$app->user->id;
            $userCategory->category_id = $category;
            $userCategory->save();
        }
    }

    private function uploadFile($optionsForm): bool
    {
        if ($optionsForm->file && $optionsForm->validate()) {
            $newName = uniqid('upload') . '.' . $optionsForm->file->getExtension();
            $optionsForm->file->saveAs('@webroot/uploads/' . $newName);

            $optionsForm->filePath = $newName;
            return true;
        }
        return false;
    }
}