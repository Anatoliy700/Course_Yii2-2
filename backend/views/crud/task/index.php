<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\TaskSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tasks', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin() ?>
    <?php $form = \yii\widgets\ActiveForm::begin(
        [
            'method' => 'get',
            'options' => [
                'data-pjax' => ''
            ]
        ]
    ) ?>
    <?= $form->field($searchModel, 'date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'yyyy-MM',
        'options' => [
            'class' => 'form-control',
            'autocomplete' => 'off',
            'data-pjax' => ''
        ]
    ]) ?>
    <?= $form->field($searchModel, 'username')->textInput() ?>
    <?= Html::submitButton('Отфильтровать') ?>
    <?php \yii\widgets\ActiveForm::end() ?>
    
    
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'item',
        'itemOptions' => function ($model) {
            return ['tag' => 'a', 'href' => \yii\helpers\Url::to(['view', 'id' => $model->id])];
        },
    ]) ?>
    <?php \yii\widgets\Pjax::end() ?>


    <!--  --><? //= GridView::widget([
    //    'dataProvider' => $dataProvider,
    //    'filterModel' => $searchModel,
    //    'columns' => [
    //      ['class' => 'yii\grid\SerialColumn'],
    //
    //      'id',
    //      'title',
    //      'description',
    //      'date',
    ////            'user_id',
    //      'username',
    //
    //      ['class' => 'yii\grid\ActionColumn'],
    //    ],
    //  ]); ?>
</div>
