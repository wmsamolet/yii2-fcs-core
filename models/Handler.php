<?php

namespace wmsamolet\fcs\core\models;

use Yii;

/**
 * This is the model class for table "{{%fcs_handler}}".
 *
 * @property int $id
 * @property string $class
 * @property string $function
 * @property string $description
 * @property int $is_active
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class Handler extends \wmsamolet\fcs\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fcs_handler}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class', 'function', 'description'], 'required'],
            [['is_active', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['class', 'function', 'description'], 'string', 'max' => 255],
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
            'function' => Yii::t('app', 'Function'),
            'description' => Yii::t('app', 'Description'),
            'is_active' => Yii::t('app', 'Is Active'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
