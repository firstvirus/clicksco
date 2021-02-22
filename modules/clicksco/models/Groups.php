<?php

namespace app\modules\clicksco\models;

use Yii;

/**
 * This is the model class for table "{{%clicksco_groups}}".
 *
 * @property int $id
 * @property string $link
 * @property int $ready
 */
class Groups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%clicksco_groups}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link'], 'required'],
            [['ready'], 'integer'],
            [['link'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'ready' => 'Ready',
        ];
    }
}
