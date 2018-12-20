<?php

namespace common\models;


use common\models\tables\Images;
use dosamigos\transliterator\TransliteratorHelper;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\helpers\Inflector;

class Image extends Images
{
    /* @var \yii\web\UploadedFile */
    public $image;
    protected $path = [
        'origin' => '@imgPath/task/',
        'small' => '@imgPath/task/small/'
    ];
    
    public function rules() {
        $rules = [
            [['image'], 'required'],
            [
                ['image'], 'file',
                'extensions' => 'jpg, png',
                'maxSize' => 3e+6,
            ]
        ];
        
        return ArrayHelper::merge(parent::rules(), $rules);
    }
    
    public function upload($id) {
        $this->name = $this->translit($this->image->getBaseName()) . '.' . $this->image->getExtension();
        $this->task_id = (int)$id;
        if ($this->validate()) {
            $fileName = $this->path['origin'] . $this->name;
            $this->image->saveAs(\Yii::getAlias($fileName));
            \yii\imagine\Image::thumbnail($fileName, '200', null)
                ->save(\Yii::getAlias($this->path['small'] . $this->name));
            $model = new Images();
            $model->setAttributes($this->attributes);
            if ($model->save()) {
                $this->id = $model->primaryKey;
                return true;
            }
        }
        return false;
    }
    
    static public function getDataProvider($id) {
        return new ActiveDataProvider([
            'query' => Images::find()->where(['task_id' => $id])
        ]);
    }
    
    public function translit($str) {
        return Inflector::slug(TransliteratorHelper::process($str), '-', true);
    }
    
    public function delete() {
        BaseFileHelper::unlink(\Yii::getAlias($this->path['origin'] . $this->name));
        BaseFileHelper::unlink(\Yii::getAlias($this->path['small'] . $this->name));
        return parent::delete();
    }
    
}