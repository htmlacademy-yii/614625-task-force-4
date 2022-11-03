<?php
use yii\widgets\ActiveForm;
use app\models\Categories;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Публикация нового задания';
$categories = ArrayHelper::map(Categories::find()->all(), 'id', 'name');
?>
<main class="main-content main-content--center container">
    <div class="add-task-form regular-form">
        <?php $createForm = ActiveForm::begin([
            'id' => 'task-create-form',
            'method' => 'post',
            'options' => ['enctype' => 'multipart/form-data']
        ]);?>
            <h3 class="head-main head-main">Публикация нового задания</h3>
            <div class="form-group">
                <?=$createForm->field($taskCreateForm, 'name', ['labelOptions' => ['for' => 'essence-work','class' => 'control-label'],
                    'inputOptions' => ['id' => 'essence-work']]);?>
            </div>
            <div class="form-group">
            <?=$createForm->field($taskCreateForm, 'description', ['labelOptions' => ['for' => 'username','class' => 'control-label'],
                'inputOptions' => ['id' => 'username']])->textarea(); ?>
            </div>
            <div class="form-group">
            <?=$createForm->field($taskCreateForm, 'category', ['labelOptions' => ['for' => 'town-user','class' => 'control-label'],
                'inputOptions' => ['id' => 'town-user']])->dropDownList($categories); ?>
            </div>
            <div class="form-group">
                <label class="control-label" for="location">Локация</label>
                <input class="location-icon" id="location" type="text">
                <span class="help-block">Error description is here</span>
            </div>
            <div class="half-wrapper">
                <div class="form-group">
                    <?=$createForm->field($taskCreateForm, 'budget', [
                        'labelOptions' => ['for' => 'budget','class' => 'control-label'],
                        'inputOptions' => ['id' => 'budget']])->input('budget', ['class' => 'budget-icon']); ?>
                </div>
                <div class="form-group">
                    <?=$createForm->field($taskCreateForm, 'dateCompletion', [
                        'labelOptions' => ['for' => 'period-execution','class' => 'control-label'],
                        'inputOptions' => ['id' => 'period-execution']])->input('date'); ?>
                </div>
            </div>
            <p class="form-label">Файлы</p>
                <?=$createForm->field($taskCreateForm, 'files[]', ['template' => "<label class=\"new-file\" >Добавить новый файл{input}",
                'inputOptions' => ['style' => 'display: none']])->fileInput(['multiple' => true]);?>
            </p>
            <?= Html::SubmitInput('Опубликовать', ['class' => 'button button--blue'])?>
        <?php ActiveForm::end();?>
    </div>
</main>