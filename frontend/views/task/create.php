<?php
/* @var $this yii\web\View */

/* @var $model \frontend\models\Task */

/* @var $users array */

use yii\helpers\Html;

$this->title = 'Добавить задачу';
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ["/project"]];
$this->params['breadcrumbs'][] = [
    'label' => "Задачи в {$model->project->name}",
    'url' => ['index', 'project_id' => $model->project_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tasks-create col-lg-4">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
        'users' => $users,
    ]) ?>
</div>
