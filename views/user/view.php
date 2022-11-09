<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main"><?=$user->name?></h3>
        <div class="user-card">
            <div class="photo-rate">
                <img class="card-photo" src="/uploads/<?=(Yii::$app->user->getIdentity()->avatar);?>" width="191" height="190" alt="Фото пользователя">
                <div class="card-rate">
                    <div class="stars-rating big"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                    <span class="current-rate">4.23</span>
                </div>
            </div>
            <p class="user-description">
                <?=$user->description;?>
            </p>
        </div>
        <div class="specialization-bio">
            <div class="specialization">
                <p class="head-info">Специализации</p>
                <ul class="special-list">
                    <?php foreach ($user->userCategories as $category):?>
                        <li class="special-item">
                            <a href="#" class="link link--regular"><?=$category->category->name?></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info"><span class="country-info">Россия</span>, <span class="town-info"><?=$user->city->name?></span>, <span class="age-info">30</span> лет</p>
            </div>
        </div>

        <h4 class="head-regular">Отзывы заказчиков</h4>
        <?php foreach ($user->reviews as $review):?>
            <div class="response-card">
                <img class="customer-photo" src="/uploads/<?=$review->user->avatar;?>" width="120" height="127" alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    <p class="feedback"><?=$review->text?></p>
                    <p class="task">Задание «<a href="/tasks/view?id=<?=$review->task->id?>" class="link link--small"><?=$review->task->title?></a>» <?=$review->task->getStatusName();?></p>
                </div>
                <div class="feedback-wrapper">
                    <div class="stars-rating small"><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span class="fill-star">&nbsp;</span><span>&nbsp;</span></div>
                    <p class="info-text"><span class="current-time"><?=Yii::$app->formatter->asRelativeTime($review->creation_time)?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <h4 class="head-card">Статистика исполнителя</h4>
            <dl class="black-list">
                    <dt>Всего заказов</dt>
                    <dd><?=$user->getExecutedTasks()->count();?> выполнено, <?=$user->getFailedTasks()->count();?> провалено</dd>
                    <dt>Место в рейтинге</dt>
                    <dd></dd>
                    <dt>Дата регистрации</dt>
                    <dd><?=$user->creation_time?></dd>
                    <dt>Статус</dt>
                    <dd>Открыт для новых заказов</dd>
            </dl>
        </div>
        <div class="right-card white">
            <h4 class="head-card">Контакты</h4>
            <ul class="enumeration-list">
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--phone"><?=$user->phone?></a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--email"><?=$user->email?></a>
                </li>
                <li class="enumeration-item">
                    <a href="#" class="link link--block link--tg"><?=$user->telegram?></a>
                </li>
            </ul>
        </div>
    </div>
</main>