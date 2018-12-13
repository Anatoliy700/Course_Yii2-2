<?php
/* @var $this yii\web\View */

/* @var $model \common\models\tables\Tasks */

/* @var $usersSelect array */
/* @var $projectsSelect array */

/* @var $statusesSelect array */

use yii\helpers\Html;

$this->title = 'Изменить задачу';
$this->params['breadcrumbs'][] = [
    'label' => 'Задачи',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tasks-create col-lg-4">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= $this->render('_form', [
        'model' => $model,
        'usersSelect' => $usersSelect,
        'projectsSelect' => $projectsSelect,
        'statusesSelect' => $statusesSelect,
    ]) ?>
</div>
