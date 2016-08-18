<?php

namespace luckynvic\option\models;

use Yii;

/**
 * This is the model class for table "option".
 *
 * @property string $id
 * @property string $content
 */
class OptionModel extends \yii\db\ActiveRecord
{
    const CACHE_PREFIX = 'option_cache_';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'option';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['content'], 'string'],
            [['id'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
        ];
    }

}
