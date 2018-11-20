<?php

/* @var $message string */

/* @var $model \frontend\models\Task */

/* @var $users array */

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;
use \yii\jui\DatePicker;

?>
<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'description')->textarea() ?>
<?= $form->field($model, 'date')->widget(DatePicker::class, [
    'dateFormat' => 'yyyy-MM-dd',
    'options' => [
        'class' => 'form-control',
        'autocomplete' => 'off',
    ]
]) ?>
<?= $form->field($model, 'user_id')->dropDownList($users) ?>
<?= HTML::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
