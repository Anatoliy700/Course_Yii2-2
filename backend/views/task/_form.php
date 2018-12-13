<?php

/* @var $message string */
/* @var $model \common\models\tables\Tasks */
/* @var $usersSelect array */
/* @var $projectsSelect array */

/* @var $statusesSelect array */

/* @var $this \yii\web\View */


use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

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
<?= $form->field($model, 'user_id')->dropDownList($usersSelect) ?>
<?= $form->field($model, 'project_id')->dropDownList($projectsSelect) ?>
<?= $form->field($model, 'status_id')->dropDownList($statusesSelect) ?>
<?= $form->field($model, 'initiator_id')->dropDownList(
    $usersSelect,
    ['value' => Yii::$app->user->identity->id]
) ?>
<?= HTML::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
