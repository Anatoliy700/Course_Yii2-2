<?php
/* @var \common\models\search\TeamsSearch $teamSearch */

/* @var \yii\data\ActiveDataProvider $dataProvider */

use yii\helpers\Url;

$this->title = 'Команды';
$this->params['breadcrumbs'][] = $this->title;

?>

<p>
    <?= \yii\helpers\Html::a(
        'Создать команду',
        ['team/create'],
        ['class' => 'btn btn-success']
    ) ?>
</p>

<?= \yii\widgets\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => 'item',
    'layout' => "{summary}\n<div class='row'>{items}</div>\n{pager}",
    'itemOptions' => function ($model) {
        return ['tag' => 'a', 'href' => Url::to(['team/view', 'teamId' => $model->id])];
    },
]) ?>
