<?php

/* @var $message string */
/* @var $model \frontend\models\Task */
/* @var $users array */
/* @var $statuses array */

/* @var $this \yii\web\View */


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
<?= $form->field($model, 'project_id')->hiddenInput()->label(false)
?>

<?php
if (Yii::$app->user->can('productManager') && $this->context->action->id !== 'create') {
    echo $form->field($model, 'status_id')->dropDownList($statuses);
} else {
    echo $form->field($model, 'status_id')->hiddenInput()->label(false);
}
?>
<?= HTML::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
