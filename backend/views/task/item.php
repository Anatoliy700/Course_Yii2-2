<?php
/* @var \common\models\tables\Tasks $model */

use yii\helpers\Html;

$optionsP = [];
$optionsDiv = ['class' => 'task-item box box-default box-solid'];


if ($model->status_id === \common\models\tables\Tasks::STATUS_IN_WORK && date_create($model->date) < date_create()) {
    Html::addCssClass($optionsP, 'overdue-task');
    Html::removeCssClass($optionsDiv, 'box-default');
    Html::addCssClass($optionsDiv, 'box-danger');
} elseif ($model->status_id === \common\models\tables\Tasks::STATUS_COMPLETE){
    Html::removeCssClass($optionsDiv, 'box-default');
    Html::addCssClass($optionsDiv, 'box-success');
}

?>

<?= Html::beginTag('div', $optionsDiv) ?>
<div class="box-header with-border"><?= $model->title ?></div>
<div class="box-body">
    <p><?php echo $model->getAttributeLabel('username') . ' : ' . $model->username ?></p>
    <p><?php echo $model->getAttributeLabel('created_at') . ' : ' . $model->created_at ?></p>
    <p><?php echo $model->getAttributeLabel('initiatorName') . ' : ' . $model->initiatorName ?></p>
    <?= Html::tag('p', $model->getAttributeLabel('date') . ' : ' . $model->date, $optionsP) ?>
    <?php if ($model->status_id === \common\models\tables\Tasks::STATUS_COMPLETE && !is_null($model->done_date)): ?>
        <p><?php echo $model->getAttributeLabel('done_date') . ' : ' . $model->done_date ?> </p>
    <?php endif; ?>
</div>
<?= Html::endTag('div') ?>

