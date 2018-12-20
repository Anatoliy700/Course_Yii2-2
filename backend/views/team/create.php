<?php
/* @var \common\models\tables\Teams $model */

use yii\helpers\Html;

$this->title = 'Создание новой команды';
$this->params['breadcrumbs'][] = ['label' => 'Команды', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="team-create">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

