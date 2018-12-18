<?php
/* @var \yii\web\View $this */
/* @var \yii\data\ActiveDataProvider $dataProvider */

/* @var \backend\models\search\TaskSearch $searchModel */

use yii\helpers\Html;

\common\assets\TaskAsset::register($this);

$this->title = 'Задачи';
$this->params['breadcrumbs'][] = $this->title;

$defaultBtnClass = 'btn-primary';
$defaultBtnClassActive = 'btn-success';
$btnOptions = [
    'day' => ['class' => "btn {$defaultBtnClass}"],
    'week' => ['class' => "btn {$defaultBtnClass}"],
    'month' => ['class' => "btn {$defaultBtnClass}"],
];
$btnNames = [
    'index' => 'Все',
    'done' => 'Выполненные',
    'overdue' => 'Просроченные',
];
$period = \Yii::$app->request->get('period');
if (isset($period) && isset($btnOptions[$period])) {
    $options = &$btnOptions[$period];
    Html::removeCssClass($options, $defaultBtnClass);
    Html::addCssClass($options, $defaultBtnClassActive);
}

?>

<?php \yii\widgets\Pjax::begin() ?>
<div class="clearfix">
    <div class="btn-filter-primary btn-group pull-right">
        <button type="button" class="btn btn-info"><?= $btnNames[$this->context->action->id] ?></button>
        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li><a href="index">Все</a></li>
            <li><a href="done">Выполненные</a></li>
            <li><a href="overdue">Просроченные</a></li>
        </ul>
    </div>
</div>
<?php if ($this->context->action->id === 'done' || $this->context->action->id === 'overdue'): ?>
    <div class="clearfix">
        <div class="btn-filter-secondary btn-group pull-right">
            <?= Html::a('День', [$this->context->action->id, 'period' => 'day'], $btnOptions['day']) ?>
            <?= Html::a('Неделя', [$this->context->action->id, 'period' => 'week'], $btnOptions['week']) ?>
            <?= Html::a('Месяц', [$this->context->action->id, 'period' => 'month'], $btnOptions['month']) ?>
        </div>
    </div>
<?php endif; ?>

<div class="task-index">
    <p>
        <?= \yii\helpers\Html::a('Добавить задачу', ['create'], ['class' => 'btn btn-primary']) ?>
    </p>
    
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