<?php

/* @var $dataProvider \yii\data\ActiveDataProvider */

/* @var $searchModel \frontend\modules\lk\models\search\TaskSearch */

use yii\helpers\Html;

$this->title = 'Мои задачи';
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/lk']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="tasks-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="task-search-form clearfix" style="margin-bottom: 20px">
        <?php $form = \yii\widgets\ActiveForm::begin([
            'method' => 'get',
            'options' => [
                'class' => 'col-lg-2',
                'style' => 'border: solid 1px #bdadad; padding: 5px'
            ]
        ]) ?>
        <?= $form->field($searchModel, 'date')->widget(\yii\jui\DatePicker::class, [
            'dateFormat' => 'yyyy-MM',
            'options' => [
                'class' => 'form-control',
                'autocomplete' => 'off',
            ],
        ]) ?>
        <?= Html::submitButton('Отфильтровать', ['class' => 'btn btn-primary']) ?>
        <?php \yii\widgets\ActiveForm::end() ?>
    </div>
    <div class="wrap-tasks">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'item',
            'layout' => "{summary}\n<div class='row clearfix'>{items}</div>\n{pager}",
            'itemOptions' => function ($model) {
                return ['tag' => 'a', 'href' => \yii\helpers\Url::to(['view', 'id' => $model->id])];
            },
        ]) ?>
    </div>

</div>
