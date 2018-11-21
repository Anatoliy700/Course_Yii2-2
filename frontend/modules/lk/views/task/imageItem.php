<?php
use \yii\helpers\Html;
/* @var $model \common\models\tables\Images */
?>

<div class="image-wrap col-md-3">
    <?= Html::beginTag('a', [
        'href' => Yii::getAlias($directoryAsset . $model->name),
        'target' => '_blank',
        ]) ?>
    <?= Html::img(Yii::getAlias($directoryAsset . 'small/' . $model->name)) ?>
    <?= Html::endTag('a') ?>
</div>
