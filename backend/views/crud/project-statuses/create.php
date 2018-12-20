<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tables\ProjectStatuses */

$this->title = 'Create Project Statuses';
$this->params['breadcrumbs'][] = ['label' => 'Project Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-statuses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
