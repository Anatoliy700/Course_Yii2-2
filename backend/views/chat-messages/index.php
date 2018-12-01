<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ChatMessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chat Messages';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chat-messages-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Chat Messages', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <?php \yii\widgets\Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task_id',
            'user_id',
            'message',
            'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
