<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectStatusesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Project Statuses';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-statuses-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project Statuses', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php \yii\widgets\Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
