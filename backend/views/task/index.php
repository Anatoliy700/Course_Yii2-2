<?php
/* @var \yii\web\View $this */
/* @var \yii\data\ActiveDataProvider $dataProvider */
/* @var \backend\models\search\TaskSearch $searchModel */

\common\assets\TaskAsset::register($this);

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="task-index">
    <p>
        <?= \yii\helpers\Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin() ?>
    
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{summary}\n<div class='row'>{items}</div>\n{pager}",
        'itemView' => 'item',
        'itemOptions' => function ($model) {
            /* @var \common\models\tables\Tasks $model */
            return [
                'tag' => 'a',
                'class' => 'col-lg-4',
                'href' => \yii\helpers\Url::to(['view', 'id' => $model->id]),
                'data' => [
                    'pjax' => 0
                ]
            ];
        }
    ]) ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>