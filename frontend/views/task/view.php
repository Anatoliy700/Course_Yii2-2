<?php

use yii\widgets\DetailView;
use \yii\helpers\Html;

/* @var $model \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $imageModel \common\models\Image */

/* @var $chatDataProvider \yii\data\ActiveDataProvider */
/* @var $chatMessageModel \common\models\tables\ChatMessages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ["index"]];
$this->params['breadcrumbs'][] = $this->title;

frontend\assets\TaskViewAsset::register($this);
\app\frontend\components\chat\assets\ChatAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl($this->assetBundles['frontend\assets\TaskViewAsset']->sourcePath) . '/';
?>

<div class="left-content col-lg-8">
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
</div>
<div class="right-content col-lg-4">
    <div class="wraps-chat">
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Task Chat</h3>
                <h6 id="chat-connected" class="box-title pull-right">Disconnect</h6>
            </div>
            <div class="box-body">
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $chatDataProvider,
                    'itemView' => '@app/components/chat/view/chatMessageItem',
                    'itemOptions' => ['tag' => false],
                    'summary' => '',
                    'emptyText' => false,
                    'options' => [
                        'id' => 'messages_items',
                        'class' => 'direct-chat-messages',
                    ],
                ]) ?>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest): ?>
            <div class="box-footer">
                <?php $form = \yii\widgets\ActiveForm::begin([
                    'id' => 'taskChat',
                    'action' => false,
                ]); ?>
                <?= $form
                    ->field($chatMessageModel, 'task_id')
                    ->hiddenInput(['value' => $model->id])
                    ->label(false) ?>
                <?= $form
                    ->field($chatMessageModel, 'user_id')
                    ->hiddenInput(['value' => \Yii::$app->user->id ?? 0])
                    ->label(false) ?>
                <?= Html::hiddenInput(
                    'fullName',
                    Yii::$app->user->identity->first_name
                    . ' ' .
                    Yii::$app->user->identity->last_name
                ) ?>
                <div class="input-group">
                    <?= $form->field($chatMessageModel,
                        'message',
                        [
                            'options' => ['tag' => false],
                            'template' => "{input}",
                        ]
                    )->textInput()->label(false) ?>
                    <span class="input-group-btn">
                        <?= Html::submitButton(
                            'Оправить', [
                                'disabled' => true,
                                'class' => 'btn btn-primary btn-flat',
                            ]
                        ) ?>
                    </span>
                </div>
                <?php \yii\widgets\ActiveForm::end(); ?>
            </div>
        <?php endif; ?>
    </div>
</div>
