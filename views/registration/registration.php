<?php
use yii\widgets\ActiveForm;
use app\models\Cities;
?>
<main class="container container--registration">
    <div class="center-block">
        <div class="registration-form regular-form">
            <?php $registrationForm = ActiveForm::begin(['id' => 'registrationform'])?>
                <h3 class="head-main head-task">Регистрация нового пользователя</h3>
                <?php echo $registrationForm->field($model, 'name')->textInput(['class' => 'control-label']);?>
                <div class="half-wrapper">
                    <?php echo $registrationForm->field($model, 'email')->textInput(['class' => 'control-label']);?>
                    <?php echo $registrationForm->field($model, 'cityId')->dropDownList(Cities::getCityList());  ?>
                </div>
                <div class="half-wrapper">
                <?php echo $registrationForm->field($model, 'password')->passwordInput(['class' => 'control-label']);  ?>
                </div>
                <div class="half-wrapper">
                    <?php echo $registrationForm->field($model, 'repeatPassword')->passwordInput(['class' => 'control-label']);  ?>
                </div>
                <?php echo $registrationForm->field($model, 'isExecutor')->checkbox(['class' => 'control-label', 'checked ' => true]);  ?>
                <input type="submit" class="button button--blue" value="Создать аккаунт">
            <?php ActiveForm::end();?>
        </div>
    </div>
</main>