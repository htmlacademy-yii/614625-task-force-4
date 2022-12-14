<?php

use app\models\CompleteTaskForm;
use app\models\Task;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
?>

<section class="pop-up pop-up--completion pop-up--close">
    <div class="pop-up--wrapper">
        <h4>Завершение задания</h4>
        <p class="pop-up-text">
            Вы собираетесь отметить это задание как выполненное.
            Пожалуйста, оставьте отзыв об исполнителе и отметьте отдельно, если возникли проблемы.
        </p>
        <div class="completion-form pop-up--form regular-form">
            <?php $form = ActiveForm::begin([
                'action' => ['tasks/complete', 'id' => $task->id],
                'method' => 'post',
                'fieldConfig' => [
                    'template' => '{label}{input}{error}',
                ],
            ]); ?>

            <?= Html::activeHiddenInput($model, 'task_id', ['value' => $task->id]) ?>
            <?= Html::activeHiddenInput($model, 'customer_id', ['value' => $task->customer_id]) ?>
            <?= Html::activeHiddenInput($model, 'executor_id', ['value' => $task->executor_id]) ?>

            <?=$form->field($model, 'text')->textarea()->label('Ваш комментарий');?>
            <?= Html::tag('p', 'Оценка работы', ['class' => 'completion-head control-label']) ?>
            
            <?= Html::activeHiddenInput($model, 'stars') ?><div class="stars-rating big active-stars">
                <span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span><span>&nbsp;</span>
            </div>

            <?= Html::submitInput('Завершить', ['class' => 'button button--pop-up button--blue']) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="button-container">
            <button class="button--close" type="button">Закрыть окно</button>
        </div>
    </div>
</section>