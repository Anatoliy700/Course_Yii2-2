<?php
/* @var \common\models\tables\Teams $teamModel */
/* @var \common\models\search\UserSearchNotInTeam $usersSearch */
/* @var \yii\data\ActiveDataProvider $usersDataProvider */

$this->title = "Добавление пользователей в команду {$teamModel->name}";
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $teamModel->name, 'url' => ['/team/view', 'teamId' => $teamModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= \yii\helpers\Html::beginForm() ?>
<?php \yii\widgets\Pjax::begin() ?>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $usersDataProvider,
    'filterModel' => $usersSearch,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'username',
        [
            'class' => \yii\grid\CheckboxColumn::class,
            'name' => 'usersId',
        ]
    ]
]) ?>

<?php \yii\widgets\Pjax::end() ?>
<?= \yii\helpers\Html::submitButton('Добавить') ?>
<?php \yii\helpers\Html::endForm() ?>


