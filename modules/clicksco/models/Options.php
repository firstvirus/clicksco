<?php

namespace app\modules\clicksco\models;

//use Yii;

/**
 * This is the model class for table "{{%clicksco_options}}".
 *
 * @property string $key
 * @property string|null $value
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clicksco_options}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key'], 'required'],
            [['key', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'    => 'ID',
            'key'   => 'Key',
            'value' => 'Value',
        ];
    }
}
