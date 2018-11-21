<?php

use yii\widgets\DetailView;
use \yii\helpers\Html;

/* @var $model \frontend\models\Task */
/* @var $imageModel \frontend\modules\lk\models\Image */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $taskId string */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Личный кабинет', 'url' => ['/lk']];
$this->params['breadcrumbs'][] = ['label' => 'Мои задачи', 'url' => ["index"]];
$this->params['breadcrumbs'][] = $this->title;
\frontend\assets\TaskViewAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl($this->assetBundles['frontend\assets\TaskViewAsset']->sourcePath) . '/';

?>


<div class="task-wrap">
    <?= Html::tag('h2', $model->title) ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'date:date',
            'description',
            'username',
            'created_at',
            'updated_at',
        ]
    ]) ?>
</div>

<div class="task-images-wrap clearfix">
    <?= \yii\widgets\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => 'imageItem',
        'summary' => '',
        'emptyText' => false,
        'viewParams' => [
            'directoryAsset' => $directoryAsset,
        ]
    ]) ?>
</div>

<div class="add-image">
    <h3>Добавить изображение</h3>
    <?= $this->render('imageForm', [
        'model' => $imageModel,
        'taskId' => $taskId,
    ]) ?>
</div>

