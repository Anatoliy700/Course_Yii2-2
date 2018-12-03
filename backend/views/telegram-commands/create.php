<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\tables\TelegramCommands */

$this->title = 'Create Telegram Commands';
$this->params['breadcrumbs'][] = ['label' => 'Telegram Commands', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="telegram-commands-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
