<?php
namespace luckynvic\option\components;

use Yii;
use yii\base\Component;
use yii\helpers\Json;
use luckynvic\option\models\OptionModel;

/**
* 
*/
class OptionComponent extends Component
{
    public function get($id, $index=null, $default=null)
    {
        if(($content = Yii::$app->cache->get(OptionModel::CACHE_PREFIX.$id))===false) {
            if(($model = OptionModel::findOne($id))===null)
              return $default;
            $content = Json::decode($model->content);
            Yii::$app->cache->set(Option::CACHE_PREFIX.$id, $content);
        }
        if($index!==null && is_array($content))
            return array_key_exists($index, $content)?$content[$index]:$default;
        else
            return $content;
    }

    public function set($id, $value, $index=null)
    {
        if(($model = OptionModel::findOne($id))===null)
          $model = new OptionModel;
        else
        {
            if($value==null && $index==null) {
                $model->delete();
                Yii::$app->cache->delete(OptionModel::CACHE_PREFIX.$id);    
                return;
            }
        }

        $content = $model->content;
        if($index!==null)
            $content[$index] = $value;
        else
            $content = $value;

        $model->id = $id;
        $model->content = Json::encode($content);
        if($model->save())
            Yii::$app->cache->set(OptionModel::CACHE_PREFIX.$id, $content);
    }

    public function delete($id, $index=null)
    {
        if(($content=$this->get($id, $index, null))===null)
            return;
        if($index!==null) {
            unset($content[$index]);
            $this->set($id, $content, $index);
        } else
            $this->set($id, null);
    }
}