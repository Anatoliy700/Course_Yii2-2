<?php
?>



<div >
    <?= \yii\helpers\Html::tag('h2', $model->title) ?>
 <?= \yii\widgets\DetailView::widget([
        'model' => $model,
        'attributes' => [
            'title',
            'description',
            'date',
            'username',
        ]
 ])  ?>
</div>
