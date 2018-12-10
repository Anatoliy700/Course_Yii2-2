<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\tables\TeamsUsers */

$this->title = 'Update Teams Users: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Teams Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="teams-users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
