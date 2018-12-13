<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $models \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $project \common\models\tables\Projects */

\common\assets\TaskAsset::register($this);

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \yii\widgets\Pjax::begin()?>
<div class="task-index">
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
</div>
<?php \yii\widgets\Pjax::end() ?>