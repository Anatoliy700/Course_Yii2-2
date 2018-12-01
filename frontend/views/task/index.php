<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $models \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $project \common\models\tables\Projects */

$this->title = "Задачи в {$project->name}";
$this->params['breadcrumbs'][] = ['label' => 'Проекты', 'url' => ["/project"]];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?php if (Yii::$app->user->can('createTask')): ?>
        <?= Html::a(Yii::t('app/main', 'Создать'), ['create', 'project_id' => $project->id], ['class' => 'btn btn-success']) ?>
    <?php endif; ?>
   
</p>


<div class="tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    
    
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'item',
        'layout' => "{summary}\n<div class='row'>{items}</div>\n{pager}",
        'itemOptions' => function ($model) {
            return ['tag' => 'a', 'href' => Url::to(['task/view', 'id' => $model->id])];
        },
    ]) ?>

</div>