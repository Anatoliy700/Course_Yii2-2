<?php
/* @var $this yii\web\View */
/* @var $user \common\models\User */

$this->title = 'Личный кабинет';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= $this->title ?></h1>

<p>
    Здравствуйте <b><?= $user->first_name ?> <?= $user->last_name ?></b>, ваш логин <b><?= $user->username ?></b>
</p>

<p>
    <?= \yii\helpers\Html::a('Мои задачи', \yii\helpers\Url::to(['task/index'])) ?>
</p>