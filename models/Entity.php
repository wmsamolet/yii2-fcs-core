<?php

namespace wmsamolet\fcs\core\models;

use Yii;

/**
 * This is the model class for table "{{%fcs_entity}}".
 *
 * @property int $id
 * @property int $group_id
 * @property string $title
 * @property string $class
 * @property string $table
 * @property string $categories_table
 * @property string $slug_attribute
 * @property int $sort_order
 * @property string $created_at
 * @property string $updated_at
 */
class Entity extends \wmsamolet\fcs\core\components\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%fcs_entity}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'sort_order'], 'integer'],
            [['title', 'class'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'class', 'table', 'categories_table', 'slug_attribute'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'group_id' => Yii::t('app', 'Group ID'),
            'title' => Yii::t('app', 'Title'),
            'class' => Yii::t('app', 'Class'),
            'table' => Yii::t('app', 'Table'),
            'categories_table' => Yii::t('app', 'Categories Table'),
            'slug_attribute' => Yii::t('app', 'Slug Attribute'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
