<?php
use yii\widgets\ActiveForm;
use app\models\Categories;
use app\calculate\MainCalculate;
use yii\helpers\Url;
use yii\widgets\ListView;
?>
<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Мои задания</h3>
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
    </div>
</main>
