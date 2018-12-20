<?php
/* @var \common\models\tables\Teams $teamModel */

$this->title = $teamModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <h4>Описание</h4>
    <p>
        <?= $teamModel->description ?>
    </p>
</div>
<div>
    <h4>Участники</h4>
    <?php \yii\widgets\Pjax::begin() ?>
    <?= \yii\grid\GridView::widget([
        'dataProvider' => new \yii\data\ActiveDataProvider(['query' => $teamModel->getUsers()]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'username',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return \yii\helpers\Html::a(
                            'Исключить',
                            [
                                'team/delete-user',
                                'teamId' => Yii::$app->request->get('teamId'),
                                'userId' => $model->id,
                            ],
                            [
                                'data' => [
                                    'confirm' => 'Удалить пользователя из команды?',
                                    'method' => 'post',
                                    'pjax' => ''
                                ]
                            ]
                        );
                    }
                ],
            ],
        ]
    ]) ?>
    <?php \yii\widgets\Pjax::end() ?>
</div>

<div class="btn-block">
    <?= \yii\helpers\Html::a(
        'Добавить пользователей',
        [
            'team/add-users',
            'teamId' => $teamModel->id
        ],
        ['class' => 'btn btn-success']
    ) ?>
    <?= \yii\helpers\Html::a(
        'Расформировать команду',
        [
            'team/delete',
            'teamId' => $teamModel->id
        ],
        [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Расформировать команду?',
                'method' => 'post'
            ]
        ]
    ) ?>
</div>
<?php if (Yii::$app->session->hasFlash('addUsers')): ?>
    <?php \yii\jui\Dialog::begin() ?>
    Добавлено <?= Yii::$app->session->getFlash('addUsers') ?> пользователей.
    <?php \yii\jui\Dialog::end() ?>
<?php endif; ?>

