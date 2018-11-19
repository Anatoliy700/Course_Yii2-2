<?php

namespace common\models;


use common\models\tables\Images;
use yii\data\ActiveDataProvider;
use yii\helpers\Inflector;
use dosamigos\transliterator\TransliteratorHelper;
use yii\helpers\BaseFileHelper;

class Image extends Images
{
    /* @var \yii\web\UploadedFile*/
    public $image;
    
    public function rules() {
        return [
            [['image'], 'required'],
            [['image'], 'file', 'extensions' => 'jpg, png']
        ];
    }
    
    public function upload(){
        if ($this->validate()){
            $this->name = $this->translit($this->image->getBaseName()) . '.' . $this->image->getExtension();
            $fileName = '@imgPath/task/' . $this->name;
            $this->image->saveAs(\Yii::getAlias($fileName));
            \yii\imagine\Image::thumbnail($fileName, '200', null)
                ->save(\Yii::getAlias('@imgPath/task/small/' . $this->name));
            $model = new Images();
            $model->setAttributes($this->attributes);
            
            if($model->save()){
                $this->id = $model->primaryKey;
                return true;
            }
        }
        return false;
    }
    static public function getDataProvider($id){
        return new ActiveDataProvider([
            'query' => Images::find()->where(['task_id' => $id])
        ]);
    }
    
    public function translit($str){
        return Inflector::slug(TransliteratorHelper::process($str), '-', true);
    }
    
    public function delete() {
        BaseFileHelper::unlink(\Yii::getAlias('@imgPath/task/') . $this->name);
        BaseFileHelper::unlink(\Yii::getAlias('@imgPath/task/small/') . $this->name);
        return parent::delete();
    }
    
}