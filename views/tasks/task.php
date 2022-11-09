<?php
use yii\widgets\ActiveForm;
use app\models\Categories;
use app\calculate\MainCalculate;
use yii\helpers\Url;
use yii\widgets\ListView;
?>
<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>
        <div class="pagination-wrapper">
        <?=ListView::widget([
            'dataProvider' => $tasks,
            'itemView' => '_task',
            'summary' => '',
            'pager' => [
                'prevPageLabel' => '',
                'nextPageLabel' => '',
                'maxButtonCount' => 3,
                'options' => [
                    'tag' => 'ul',
                    'class' => 'pagination-list'
                ],
                    'linkOptions' => ['class' => 'link link--page'],
                    'activePageCssClass' => 'pagination-item pagination-item--active',
                    'pageCssClass' => 'pagination-item',
                    'prevPageCssClass' => 'pagination-item mark',
                    'nextPageCssClass' => 'pagination-item mark',
                ],
        ]);
        ?>
        </div>   
    </div>
    <div class="right-column">
       <div class="right-card black">
           <div class="search-form">
                <?php $taskForm = ActiveForm::begin([ 'id' => 'taskform']);?>
                    <h4 class="head-card">Категории</h4>
                    <?php
                        echo $taskForm->field($model, 'category', ['template' => '{input}{error}'])->checkboxList(
                            Categories::getCategoriesList(),
                            [
                                'class' => 'checkbox-wrapper',
                                'itemOptions' => [
                                    'labelOptions' => [
                                        'class' => 'control-label',
                                    ],
                                ],
                            ]
                        ); 
                    ?>
                    <h4 class="head-card">Дополнительно</h4>
                    <?php
                        echo $taskForm->field($model, 'noExecutor', [])->checkbox([
                            'labelOptions' => [
                                'class' => 'control-label',
                            ]
                        ]);
                    ?>
                    <h4 class="head-card">Период</h4>
                    <?php
                        echo $taskForm->field($model, 'period', ['template' => '{input}{error}'])->dropDownList(
                            $model->periodAttributeLabels()
                        );
                    ?>
                    <input type="submit" class="button button--blue" value="Искать">
                <?php ActiveForm::end(); ?>
           </div>
       </div>
    </div>
</main>
