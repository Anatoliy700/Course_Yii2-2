<?php

use yii\widgets\DetailView;
use \yii\helpers\Html;

/* @var $model \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $imageModel \common\models\Image */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ["index"]];
$this->params['breadcrumbs'][] = $this->title;

frontend\assets\TaskViewAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl($this->assetBundles['frontend\assets\TaskViewAsset']->sourcePath) . '/';
?>

<p>
    <?php if (Yii::$app->user->can('updateTask')): ?>
        <?= Html::a(Yii::t('app/main', 'Изменить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
    <?php if (Yii::$app->user->can('deleteTask')): ?>
        <?= Html::a(Yii::t('app/main', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif; ?>
</p>


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
            'taskId' => $model->id,
            'directoryAsset' => $directoryAsset,
        ]
    ]) ?>
</div>

<?php if ($model->user_id === Yii::$app->user->identity->id
    || Yii::$app->user->can('productManager')
): ?>
    <div class="add-image">
        <h3>Добавить изображение</h3>
        <?= $this->render('imageForm', [
            'model' => $imageModel,
            'taskId' => $model->id,
        ]) ?>
    </div>
<?php endif; ?>

