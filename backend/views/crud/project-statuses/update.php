<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tables\ProjectStatuses */

$this->title = 'Update Project Statuses: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="project-statuses-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
