<?php
/* @var \yii\web\View $this */
/* @var array $usersStatistic */
/* @var array $tasksStatistic */

/* @var string $countTeams */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
$defaultBtnClass = 'btn-primary';
$defaultBtnClassActive = 'btn-success';
$btnOptions = [
    'day' => ['class' => "btn {$defaultBtnClass}"],
    'week' => ['class' => "btn {$defaultBtnClass}"],
    'month' => ['class' => "btn {$defaultBtnClass}"],
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
    <div class="change-period btn-group pull-right">
        <?= Html::a('День', ['statistic', 'period' => 'day'], $btnOptions['day']) ?>
        <?= Html::a('Неделя', ['statistic', 'period' => 'week'], $btnOptions['week']) ?>
        <?= Html::a('Месяц', ['statistic', 'period' => 'month'], $btnOptions['month']) ?>
    </div>
</div>
<div class="row">
    <div class="users-statistic">
        <div class="col-md-3">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Пользователи</h3>
                </div>
                <div class="box-body">
                    <p>Всего: <?= $usersStatistic['all'] ?></p>
                    <p>В командах: <?= $usersStatistic['inTeams'] ?></p>
                    <p>Свободных: <?= $usersStatistic['free'] ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="tasks-statistic">
        <div class="col-md-3">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <a href="<?= Url::to(['task/index']) ?>" data-pjax="0">
                        <h3 class="box-title">Задачи</h3>
                    </a>
                </div>
                <div class="box-body">
                    <a href="<?= Url::to(['task/index']) ?>" data-pjax="0">
                        <p>Всего: <?= $tasksStatistic['all'] ?></p>
                    </a>
                    <a href="<?= Url::to(['task/done', 'period' => Yii::$app->request->get('period')]) ?>" data-pjax="0">
                        <p class="text-green">Выполнено: <?= $tasksStatistic['done'] ?></p>
                    </a>
                    <p>В работе: <?= $tasksStatistic['inWork'] ?></p>
                    <a href="<?= Url::to(['task/overdue', 'period' => Yii::$app->request->get('period')]) ?>" data-pjax="0">
                        <p class="text-red">Просрочены: <?= $tasksStatistic['overdue'] ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="teams-statistic">
        <div class="col-md-3">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <a href="<?= Url::to(['team/index']) ?>">
                        <h3 class="box-title">Команды</h3>
                    </a>
                </div>
                <div class="box-body">
                    <a href="<?= Url::to(['team/index']) ?>">
                        <p>Всего: <?= $countTeams ?></p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php \yii\widgets\Pjax::end() ?>
