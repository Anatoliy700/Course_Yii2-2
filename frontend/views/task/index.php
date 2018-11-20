<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $models \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Задачи команды на текущий месяц';
?>

<p>
    <?php if (Yii::$app->user->can('createTask')): ?>
        <?= Html::a(Yii::t('app/main', 'Создать'), ['create'], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
   
</p>


<div class="tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'item',
        'layout' => "{summary}\n<div class='clearfix'>{items}</div>\n{pager}",
        'itemOptions' => function ($model) {
            return ['tag' => 'a', 'href' => Url::to(['task/view', 'id' => $model->id])];
        },
    ]) ?>

</div>