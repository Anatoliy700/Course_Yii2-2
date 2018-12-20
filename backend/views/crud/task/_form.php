<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\tables\Tasks */
/* @var $form yii\widgets\ActiveForm */
/* @var $users array */

?>

<div class="tasks-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <!--  --><? //= $form->field($model, 'date')->textInput(['type' => 'date']) ?>
    
    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::class, [
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'class' => 'form-control',
            'autocomplete' => 'off',
        ]
    ]) ?>
    
    <?= $form->field($model, 'status_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'project_id')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'user_id')->dropDownList($users) ?>
    
    <?= $form->field($model, 'report')->textarea() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
