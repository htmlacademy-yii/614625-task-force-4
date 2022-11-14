<?php
use yii\widgets\ActiveForm;
use app\models\Categories;
use app\calculate\MainCalculate;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\Menu;
use app\models\Tasks;
?>
<main class="main-content container">
    <div class="left-menu">
        <h3 class="head-main head-task">Мои задания</h3>
        <?php 
        if (Yii::$app->user->identity->is_customer === 1) {
        echo Menu::widget(['items' => [
            ['label' => 'Новые', 'url' => ['tasks/my', 'type' => Tasks::STATUS_NEW]],
            ['label' => 'В процессе', 'url' => ['tasks/my', 'type' => Tasks::STATUS_WORKING]],
            ['label' => 'Закрытые', 'url' => ['tasks/my', 'type' => Tasks::STATUS_COMPLETED]]],
            'options' => [
                'class' => 'side-menu-list',
            ],
            'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
            'activeCssClass'=>'side-menu-item--active',
            'itemOptions'=>['class'=>'side-menu-item'],
        ]);
        } else {
        echo Menu::widget(['items' => [
            ['label' => 'В процессе', 'url' => ['tasks/my', 'type' => Tasks::STATUS_WORKING]],
            ['label' => 'Просрочено', 'url' => ['tasks/my', 'type' => Tasks::STATUS_FAILED]],
            ['label' => 'Закрытые', 'url' => ['tasks/my', 'type' => Tasks::STATUS_COMPLETED]]],
            'options' => [
                'class' => 'side-menu-list',
            ],
            'linkTemplate' => '<a href="{url}" class="link link--nav">{label}</a>',
            'activeCssClass'=>'side-menu-item--active',
            'itemOptions'=>['class'=>'side-menu-item'],
        ]);
        }?>
    </div>
    <div class="left-column left-column--task">
        <h3 class="head-main head-regular">Новые задания</h3>
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
</main>
