<?php

use yii\widgets\ListView;

/* @var $models \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $project \common\models\tables\Projects */
/* @var \yii\data\ActiveDataProvider $teamsDataProvider */

\common\assets\TaskAsset::register($this);

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

?>
    <h3>Мои команды</h3>

<?= ListView::widget([
    'dataProvider' => $teamsDataProvider,
    'layout' => "<div class='row'>{items}</div>",
    'itemView' => 'itemTeam',
    'emptyText' => 'Вы не учавствуете ни в одной команде',
    'itemOptions' => function ($model) {
        /* @var \common\models\tables\Tasks $model */
        return [
            'tag' => 'a',
            'class' => 'col-lg-1',
            'href' => \yii\helpers\Url::to(['team/view', 'id' => $model->id]),
            'data' => [
                'pjax' => 0
            ]
        ];
    },
]) ?>

<?php \yii\widgets\Pjax::begin() ?>
    <div class="task-index">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'layout' => "{summary}\n<div class='row'>{items}</div>\n{pager}",
            'itemView' => 'item',
            'emptyText' => 'У вас нет задач',
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
            },
        ]) ?>
    </div>
<?php \yii\widgets\Pjax::end() ?>