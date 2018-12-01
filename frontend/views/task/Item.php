<?php
/* @var $model \common\models\tables\Tasks */
?>

<div class="col-sm-3">
  <p class="bg-primary"><?= $model->title ?></p>
  <p class="bg-success"><?= $model->date ?></p>
  <p class="bg-info"><?= $model->description ?></p>
  <p class="bg-info"><?= $model->username ?></p>
  <p class="bg-info"><?= $model->project->name ?></p>
  <p class="bg-info"><?= $model->status->name ?></p>
</div>
