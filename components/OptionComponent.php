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
        $cache_key = OptionModel::CACHE_PREFIX.$id;
        if(($content = Yii::$app->cache->get($cache_key))===false) {
            if(($model = OptionModel::findOne($id))===null)
              return $default;
            $content = Json::decode($model->content);
            Yii::$app->cache->set($cache_key, $content);
            Yii::trace('Load option from database: '.$id, __METHOD__);
        } else
            Yii::trace('Load option from cache: '.$id, __METHOD__);

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

        $content = Json::decode($model->content);
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
        if(($content=$this->get($id))===null)
            return;
        if($index!==null) {
            if(is_array($content) && array_key_exists($index, $content)) {
                unset($content[$index]);
                $this->set($id, $content);
            }
        } else
            $this->set($id, null);
    }
}