<?php
/* @var $this yii\web\View */

/* @var $model \frontend\models\Task */
/* @var $users array */

/* @var $statuses array */

use yii\helpers\Html;

$this->title = 'Изменение задачи ' . $model->title;
$this->params['breadcrumbs'][] = [
    'label' => "Задачи в {$model->project->name}",
    'url' => ['index', 'project_id' => $model->project_id]
];
$this->params['breadcrumbs'][] = ['label' => "{$model->title} в {$model->project->name}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tasks-create col-lg-4">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
        'statuses' => $statuses,
    ]) ?>
</div>
