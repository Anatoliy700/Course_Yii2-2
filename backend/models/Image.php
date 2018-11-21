<?php

namespace backend\models;


class Image extends \common\models\Image
{
    public function rules() {
        return [
            [['image', 'task_id'], 'required'],
            [['task_id'], 'integer'],
            [['image'], 'file', 'extensions' => 'jpg, png']
        ];
    }
}