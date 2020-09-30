<?php

namespace app\models;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;
use app\models\RubricQuery;

/**
 * This is the model class for table "rubric".
 *
 * @property int $id
 * @property string|null $name
 * @property int $lft
 * @property int $rgt
 * @property int $depth
 *
 * @property Newstorubric[] $newstorubrics
 */
class Rubric extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rubric';
    }

    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::class,
                'treeAttribute' => 'tree',
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'depthAttribute' => 'depth',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['lft', 'rgt', 'depth'], 'required'],
            [['tree', 'lft', 'rgt', 'depth'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'name'
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new RubricQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
        ];
    }

    /**
     * Gets query for [[Newstorubrics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsRubric()
    {
        return $this->hasMany(NewsRubric::class, ['rubric_id' => 'id']);
    }
}
