<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var \common\models\Image $model */
/* @var $taskId string */
?>

<div class="image-form">
    <?php $form = ActiveForm::begin([
        'action' => ['task/add-image', 'id' => $taskId],
        'options' => [
            'data-pjax' => ''
        ]
    ]) ?>
    <?= $form->field($model, 'image')->fileInput() ?>
    <?= Html::submitButton('Добавить') ?>
    <?php ActiveForm::end() ?>
</div>
