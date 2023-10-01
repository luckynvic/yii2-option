<?php

namespace luckynvic\option\traits;

trait HasOption {

    protected function optionKey()
    {
        $key = serialize($this->getPrimaryKey());
        return sprintf('%x', crc32($key.self::class));
    }

    private function getOptionId($id)
    {
        return $id .'-'.$this->optionKey();
    }


    public function setOption($id, $value, $index=null) 
    {
        return \Yii::$app->option->set($this->getOptionId($id), $value, $index);
    }

    public function getOption($id, $index=null, $default=null)
    {
        return \Yii::$app->option->get($this->getOptionId($id), $index, $default);
    }
}