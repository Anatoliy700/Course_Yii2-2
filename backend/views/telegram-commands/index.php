<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\TelegramCommandsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Telegram Commands';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-commands-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Telegram Commands', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin() ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'update_id',
            'command',
            'chat_id',
            'done',
            'date',
            //'created_at',
            //'updated_at',
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>
