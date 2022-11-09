<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<main class="main-content main-content--left container">
    <?=$this->render('optionsMenu')?>
    <div class="my-profile-form">
        <?php $form = ActiveForm::begin(['id' => 'profile-password']);?>
        <?=$form->field($model, 'oldPassword')->passwordInput(['labelOptions' => ['class' => 'control-label']])?>
        <?=$form->field($model, 'newPassword')->passwordInput(['labelOptions' => ['class' => 'control-label']])?>
        <?=$form->field($model, 'repeatPassword')->passwordInput(['labelOptions' => ['class' => 'control-label']])?>
        <?=Html::SubmitInput('Сохранить', ['class' => 'button button--blue'])?>
        <?php ActiveForm::end();?>
    </div>    
</main>