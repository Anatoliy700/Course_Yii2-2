<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tables\Subscriptions */

$this->title = 'Create Subscriptions';
$this->params['breadcrumbs'][] = ['label' => 'Subscriptions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriptions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
