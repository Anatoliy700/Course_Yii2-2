<?php
/* @var $searchModel \common\models\search\ProjectsSearch */

/* @var $dataProvider \yii\data\ActiveDataProvider */

use \yii\widgets\Pjax;
use \yii\widgets\ListView;
use \yii\widgets\ActiveForm;


\themes\adminlte\assets\AdminLteAsset::register($this);

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= $this->title ?></h1>

<?php Pjax::begin() ?>

<?php $form = ActiveForm::begin([
    'options' => [
        'class' => 'row',
        'data-pjax' => '',
    ]
]) ?>

<?= $form
    ->field($searchModel, 'name', ['options' => ['class' => 'col-lg-3']])
    ->textInput()
    ->label(false)
?>

<?= \yii\helpers\Html::submitButton('Найти', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end() ?>


<?= ListView::widget(['dataProvider' => $dataProvider,
    'itemView' => 'itemProject',
    'itemOptions' => ['class' => 'col-md-4'],
    'layout' => "{summary}\n<div class='row'>{items}</div>\n{pager}",]) ?>

<?php Pjax::end() ?>