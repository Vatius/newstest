<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Newstorubric[] $newstorubrics
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'text',
            'rubrics' => function($model) {
                return $model->rubrics;
            },
            'date' => function($model) {
                return \Yii::$app->formatter->asDatetime($model->created_at, 'php:d.m.Y H:i');
            }
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text' => 'Text',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Newstorubrics]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRubrics()
    {
        return $this->hasMany(Rubric::class, ['id' => 'rubric_id'])
            ->viaTable('newstorubric', ['news_id' => 'id']);
    }
}
