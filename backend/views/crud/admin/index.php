<?php
use yii\helpers\Html;

$this->title = 'Админ панель';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::a('Роли' ,['role/index'], ['class' => 'btn btn-primary']) ?>

<?= Html::a('Пользователи' ,['user/index'], ['class' => 'btn btn-primary']) ?>

<?= Html::a('Задачи' ,['task/index'], ['class' => 'btn btn-primary']) ?>

<?= Html::a('Изображения' ,['image/index'], ['class' => 'btn btn-primary']) ?>
