<?php
use app\models\Categories;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<main class="main-content main-content--left container">
    <?= $this->render('optionsMenu') ?>
    <div class="my-profile-form">
            <?php
            $form = ActiveForm::begin(['id' => 'options-form']) ?>
            <h3 class="head-main head-regular">Мой профиль</h3>
            <div class="photo-editing">
                <div>
                    <p class="form-label">Аватар</p>
                    <img class="avatar-preview" src="/uploads/<?=(Yii::$app->user->getIdentity()->avatar);?>" width="83" height="83">
                </div>
                <?= $form->field($model, 'file')->fileInput(['hidden' => ''])->label('Сменить аватар', ['class' => 'button button--black']) ?>
            </div>
            <?= $form->field($model, 'login')->textInput(['value' => $user->name],['labelOptions' => ['class' => 'control-label']])?>
            <div class="half-wrapper">
                <?= $form->field($model, 'email')->input('email', ['value' => $user->email], ['labelOptions' => ['class' => 'control-label']]) ?>
                <?= $form->field($model, 'bdate')->input('date', ['value' => $user->bdate], ['format' => 'php:dd.mm.YYYY', 'labelOptions' => ['class' => 'control-label']]) ?>
            </div>
            <div class="half-wrapper">
                <?= $form->field($model, 'phone')->input('tel', ['value' => $user->phone], ['labelOptions' => ['class' => 'control-label']])?>
                <?= $form->field($model, 'telegram')->textInput(['value' => $user->telegram], ['labelOptions' => ['class' => 'control-label']])?>
            </div>
                <?= $form->field($model, 'description')->textarea(['value' => $user->description],['labelOptions' => ['class' => 'control-label']]) ?>
            <div class="form-group">
                    <?= $form->field($model, 'userCategory')->checkboxList(Categories::getCategoriesList(), [
                        'class' => 'checkbox-profile',
                        'itemOptions' => [
                            'labelOptions' => [
                                'class' => 'control-label',
                            ],
                        ],
                    ]) ?>
            </div>
            <?=Html::SubmitInput('Сохранить', ['class' => 'button button--blue'])?>
            <?php ActiveForm::end() ?>
    </div>
</main>