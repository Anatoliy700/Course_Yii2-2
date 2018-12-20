<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tables\TeamsUsers */

$this->title = 'Create Teams Users';
$this->params['breadcrumbs'][] = ['label' => 'Teams Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teams-users-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
