<?php

use common\models\tables\Tasks;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var \yii\base\View $this */
/* @var $model \frontend\models\Task */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $imageModel \common\models\Image */

/* @var $chatDataProvider \yii\data\ActiveDataProvider */
/* @var $chatMessageModel \common\models\tables\ChatMessages */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Задачи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

common\assets\TaskViewAsset::register($this);
common\components\chat\assets\ChatAsset::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl($this->assetBundles['common\assets\TaskViewAsset']->sourcePath) . '/';
?>

<div class="left-content col-lg-8">
    <?php \yii\widgets\Pjax::begin() ?>
    <p>
        <?php if ($this->context->hasMethod('actionUpdate')): ?>
            <?= Html::a(
                Yii::t('app/main', 'Изменить'),
                ['update', 'id' => $model->id],
                ['class' => 'btn btn-primary']
            ) ?>
        <?php endif; ?>
        <?php if ($this->context->hasMethod('actionDelete')): ?>
            <?= Html::a(
                Yii::t('app/main', 'Удалить'),
                ['delete', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Вы хотите удалить?',
                        'method' => 'post',
                    ],
                ]) ?>
        <?php endif; ?>
        <?php if ($model->status_id === Tasks::STATUS_IN_WORK) {
            $btnText = 'Завершить';
        } else {
            $btnText = 'Завершено';
        } ?>
        <?php if ($model->user_id === Yii::$app->user->identity->id && $model->status_id === Tasks::STATUS_IN_WORK) {
            echo Html::a(
                $btnText,
                ['completed', 'id' => $model->id],
                [
                    'class' => 'btn btn-success',
                    'data' => [
                        'confirm' => 'Отметить задачу как завершенную?',
                        'method' => 'post',
                        'pjax' => '',
                    ],
                ]);
        } else {
            echo Html::tag(
                'span',
                $btnText,
                [
                    'class' => 'btn btn-success',
                    'disabled' => true,
                ]
            );
        } ?>
    </p>


    <div class="task-wrap">
        <?= Html::tag('h2', $model->title) ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'date:date',
                'description',
                'username',
                'projectName',
                'statusName',
                'initiatorName',
                [
                    'attribute' => 'done_date',
                    'visible' => !is_null($model->done_date)
                ],
                'created_at',
                'updated_at',
            ]
        ]) ?>
    </div>
    <?php \yii\widgets\Pjax::end() ?>
    
    <?php \yii\widgets\Pjax::begin([
        'enablePushState' => false
    ]) ?>
    <div class="task-images-wrap row">
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
    <?php \yii\widgets\Pjax::end() ?>
</div>
<div class="right-content col-lg-4">
    <div class="wraps-chat">
        <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Task Chat</h3>
                <h6 id="chat-connected" class="box-title pull-right">Disconnected</h6>
            </div>
            <div class="box-body">
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $chatDataProvider,
                    'itemView' => '@common/components/chat/view/chatMessageItem',
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
