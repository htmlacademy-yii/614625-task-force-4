<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

use app\assets\MainAsset;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => '@web/favicon.ico']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Taskforce</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?= Yii::$app->geocoder->getApiKey() ?>&lang=ru_RU" type="text/javascript"></script>
</head>
<body>
<?php $this->beginBody() ?>

<header class="page-header">
    <nav class="main-nav">
        <a href='/' class="header-logo">
            <img class="logo-image" src="../img/logotype.png" width=227 height=60 alt="taskforce">
        </a>
        <div class="nav-wrapper">
            <ul class="nav-list">
                <li class="list-item <?php if (Yii::$app->request->url === '/tasks') echo 'list-item--active';?> ">
                    <a href="/tasks/" class="link link--nav" >Новое</a>
                </li>
                <li class="list-item">
                    <a href="" class="link link--nav" >Мои задания</a>
                </li>
                <?php if (Yii::$app->user->identity->is_customer === 1):?>
                <li class="list-item">
                    <a href="/tasks/create" class="link link--nav" >Создать задание</a>
                </li>
                <?php endif;?>
                <li class="list-item">
                    <a href="/user/optionsmenu" class="link link--nav" >Настройки</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php if (!Yii::$app->user->isGuest):?>
    <div class="user-block">
        <a href="#">
            <img class="user-photo" src="<?= (Yii::$app->user->getIdentity()->avatar);?>" width="55" height="55" alt="Аватар">
        </a>
        <div class="user-menu">
            <p class="user-name"><?= (Yii::$app->user->getIdentity()->name); ?></p>
            <div class="popup-head">
                <ul class="popup-menu">
                    <li class="menu-item">
                        <a href="/user/optionsmenu" class="link">Настройки</a>
                    </li>
                    <li class="menu-item">
                        <a href="#" class="link">Связаться с нами</a>
                    </li>
                    <li class="menu-item">
                        <a href="<?= Url::toRoute('/site/logout') ;?>" class="link">Выход из системы</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <?php endif;?>
</header>

<?= $content ?>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage() ?>