<?php
/* @var $model \common\models\tables\ChatMessages */
?>

<div class="direct-chat-msg right">
    <div class="direct-chat-info clearfix">
        <div class="direct-chat-name pull-left"><?= $model->user->first_name . ' ' . $model->user->last_name ?></div>
        <div class="direct-chat-timestamp pull-right"><?= $model->created_at ?></div>
    </div>
    <div class="direct-chat-text"><?= $model->message ?></div>
</div>
