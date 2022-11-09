<?php 

use yii\helpers\Url;
use app\models\Tasks;
use yii\helpers\Html;
?>
<main class="main-content container">
    <div class="left-column">
        <div class="head-wrapper">
            <h3 class="head-main"><?=$task->title?></h3>
            <p class="price price--big"><?=$task->budget;?> ₽</p>
        </div>
        <p class="task-description">
            <?=$task->description;?>
        </p>

        <?php if ($task->status === Tasks::STATUS_NEW && Yii::$app->user->identity->is_customer !== 1 && !Yii::$app->user->identity->getIsUserAcceptedTask($task->id)): ?>
            <a href="#" class="button button--blue action-btn" data-action="act_response">Откликнуться на задание</a>
        <?php endif; ?>

        <?php if ($task->status === Tasks::STATUS_WORKING && $task->executor_id === Yii::$app->user->id && Yii::$app->user->identity->is_customer !== 1): ?>
            <a href="#" class="button button--orange action-btn" data-action="refusal">Отказаться от задания</a>
        <?php endif; ?>
        
        <?php if ($task->status === Tasks::STATUS_WORKING && $task->customer_id === Yii::$app->user->id && Yii::$app->user->identity->is_customer === 1): ?>
            <a href="#" class="button button--pink action-btn" data-action="completion">Завершить задание</a>
        <?php endif; ?>


        <?php if ($task->status === Tasks::STATUS_NEW && $task->customer_id === Yii::$app->user->id && Yii::$app->user->identity->is_customer === 1): ?>
            <a href="#" class="button button--pink action-btn" data-action="cancel">Отменить задание</a>
        <?php endif; ?>

        <div class="task-map">
            <div id="map" class="map" style="width:725px;height:346px;"></div>
            <p class="map-address town"><?=$task->location->cities->name?></p>
            <p class="map-address"><?=$task->location->name?></p>
        </div>
        <h4 class="head-regular">Отклики на задание</h4>

        <?php foreach ($task->responses as $response): ?>
            <?php if(!$response->is_rejected):?>
                <div class="response-card">
                    <img class="customer-photo" src="<?=$response->user->avatar?>" width="146" height="156" alt="Фото заказчиков">
                    <div class="feedback-wrapper">
                        <a href="<?php echo $url = Url::toRoute(['user/view', 'id' => $response->id])?>" class="link link--block link--big"><?=$response->user->name?></a>
                        <div class="response-wrapper">
                            <?php 
                            $summaStars = 0;
                            foreach ($response->user->reviews as $key => $review) {
                             $summaStars = $summaStars + $review->stars;
                            }
                            $meanStars = 0;
                            if($summaStars>0){
                                $meanStars = round($summaStars / count($response->user->reviews));
                            }
                            ?>
                            <div class="stars-rating small">
                                <?php for ($i=0; $i < $meanStars; $i++) :?> 
                                        <span class="fill-star">&nbsp;</span>
                                <?php endfor;?>
                                <?php for ($k = 5; $k > $meanStars; $k--) :?>
                                    <span>&nbsp;</span>
                                <?php endfor;?>
                            </div>
                            <p class="reviews"><?=count($response->user->reviews);?> отзыва</p>
                        </div>
                        <p class="response-message">
                            <?=$response->text?>
                        </p>
                    </div>
                    <div class="feedback-wrapper">
                        <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->asRelativeTime($response->creation_time)?></p>
                        <p class="price price--small"><?=$response->price?> ₽</p>
                    </div>

                    <?php if ($task->customer_id === Yii::$app->user->id && $task->status === Tasks::STATUS_NEW):?>
                    <div class="button-popup">
                        <?=Html::a('Принять', ['tasks/submit', 'id' => $task->id, 'responseId' => $response->id],
                            ['class' => 'button button--blue button--small']); ?>
                        <?= Html::a('Отказать', ['tasks/cancelr', 'id' => $task->id, 'responseId' => $response->id],
                            ['class' => 'button button--orange button--small']); ?>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
    <div class="right-column">
        <div class="right-card black info-card">
            <h4 class="head-card">Информация о задании</h4>
            <dl class="black-list">
                <dt>Категория</dt>
                <dd><?=$task->category->name?></dd>
                <dt>Дата публикации</dt>
                <dd><?=Yii::$app->formatter->asRelativeTime($task->creation_time)?></dd>
                <dt>Срок выполнения</dt>
                <dd><?=Yii::$app->formatter->asRelativeTime($task->date_completion)?></dd>
                <dt>Статус</dt>
                <dd><?=$task->getStatusName()?></dd>
            </dl>
        </div>
        <div class="right-card white file-card">
            <h4 class="head-card">Файлы задания</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">my_picture.jpg</a>
                    <p class="file-size">356 Кб</p>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--clip">information.docx</a>
                    <p class="file-size">12 Кб</p>
                </li>
            </ul>
        </div>
    </div>
</main>

<script type="text/javascript">
ymaps.ready(init);
function init(){
    var myMap = new ymaps.Map("map", {
        center: [<?=$task->location->latitude ?>, <?= $task->location->longitude?>],
        zoom: 14
    });
}
</script>
<?=$this->render('fail', ['task' => $task]) ?>
<?=$this->render('complete', ['model' => $CompleteTaskForm, 'task' => $task]) ?>
<?=$this->render('addResponse', ['model' => $ResponseForm, 'task' => $task]) ?>
<?= $this->render('cancel', ['task' => $task]) ?>

<div class="overlay"></div>
<script src="/js/main.js"></script>