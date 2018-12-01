<?php
/* @var $model  \common\models\tables\Projects */

?>

<a href="<?= \yii\helpers\Url::to(['/task/index', 'project_id' => $model->id]) ?>">
    <div class="box box-widget widget-user">
        <div class="widget-user-header bg-aqua-active">
            <h3 class="widget-user-username"><?= $model->name ?></h3>
            <h5 class="widget-user-desc"><?= $model->status->name ?></h5>
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= count($model->tasks) ?></h5>
                        <span class="description-text">Всего задач</span>
                    </div>
                </div>
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <h5 class="description-header"><?= count($model->tasksComplete) ?></h5>
                        <span class="description-text">Выполнено задач</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="description-block">
                        <h5 class="description-header"><?= count($model->tasks) - count($model->tasksComplete) ?></h5>
                        <span class="description-text">Задач в работе</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
