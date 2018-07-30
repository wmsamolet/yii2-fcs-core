<?php

namespace wmsamolet\fcs\core\models;

use Yii;

/**
 * This is the model class for table "{{%fcs_event_handler}}".
 *
 * @property int $event_id
 * @property int $handler_id
 * @property string $description
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class EventHandler extends \wmsamolet\fcs\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fcs_event_handler}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'handler_id', 'description'], 'required'],
            [['event_id', 'handler_id', 'sort_order'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['event_id', 'handler_id'], 'unique', 'targetAttribute' => ['event_id', 'handler_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => Yii::t('app', 'Event ID'),
            'handler_id' => Yii::t('app', 'Handler ID'),
            'description' => Yii::t('app', 'Description'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
