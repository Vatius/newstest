<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "newstorubric".
 *
 * @property int|null $news_id
 * @property int|null $rubric_id
 *
 * @property News $news
 * @property Rubric $rubric
 */
class NewsRubric extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'newstorubric';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'rubric_id'], 'integer'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['news_id' => 'id']],
            [['rubric_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rubric::class, 'targetAttribute' => ['rubric_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'rubric_id' => 'Rubric ID',
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::class, ['id' => 'news_id']);
    }

    /**
     * Gets query for [[Rubric]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(Rubric::class, ['id' => 'rubric_id']);
    }
}
