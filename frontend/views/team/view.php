<?php
/* @var \yii\web\View $this */
/* @var \common\models\tables\Teams $team */
/* @var \common\models\search\UsersInTeamSearch $userSearch */
/* @var \yii\data\ActiveDataProvider $userDataProvider */

$this->title = $team->name;
$this->params['breadcrumbs'][] = ['label' => 'Мои задачи', 'url' => ['task/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= $team->name ?></h2>

<?php \yii\widgets\Pjax::begin()?>
<div class="team-users-view">
    <?= \yii\grid\GridView::widget([
        'dataProvider' => $userDataProvider,
        'filterModel' => $userSearch,
        'columns' => [
            ['class' => \yii\grid\SerialColumn::class],
            'first_name',
            'last_name',
            'username',
            'email',
        ]
    ]) ?>
</div>
<?php \yii\widgets\Pjax::end() ?>