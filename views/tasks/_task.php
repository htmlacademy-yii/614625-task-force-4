<?php
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;
use app\calculate\MainCalculate;
?>
<div class="task-card">
    <div class="header-task">
        <a  href="<?php echo $url = Url::toRoute(['tasks/view', 'id' => $model->id])?>" class="link link--block link--big"><?=$model->title;?></a>
        <p class="price price--task"><?=$model->budget?> ₽</p>
    </div>
    <p class="info-text"><span class="current-time"><?=MainCalculate::normalizeDate($model->creation_time)?> </span>назад</p>
    <p class="task-text"><?=$model->description?></p>
    <div class="footer-task">
        <p class="info-text town-text"><?=$model->location->cities->name?>, <?=$model->location->name?></p>
        <p class="info-text category-text"><?=$model->category->name?></p>
        <a href="<?php echo $url = Url::toRoute(['tasks/view', 'id' => $model->id])?>" class="button button--black">Смотреть Задание</a>
    </div>
</div>