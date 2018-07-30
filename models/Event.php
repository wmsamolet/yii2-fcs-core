<?php

namespace wmsamolet\fcs\core\models;

use Yii;

/**
 * This is the model class for table "{{%fcs_event}}".
 *
 * @property int $id
 * @property string $class
 * @property string $name
 * @property string $description
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class Event extends \wmsamolet\fcs\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fcs_event}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class', 'name', 'description'], 'required'],
            [['sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['class', 'name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'class' => Yii::t('app', 'Class'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
