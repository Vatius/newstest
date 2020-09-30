<?php

namespace app\controllers;

use app\models\News;
use app\models\NewsRubric;
use app\models\Rubric;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->with('rubrics'),
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);

        $rubrics = Rubric::find()->roots()->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'rubrics' => $rubrics
        ]);
    }

    public function actionCategory($id)
    {
        $res = NewsRubric::findAll(['rubric_id' => $id]);
        $ids = [];
        foreach ( $res as $it) {
            $ids[] = $it->news_id;
        }
        // maybe use joins
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['id' => $ids]),
            'pagination' => [
                'pageSize' => 5,
            ]
        ]);

        $rubrics = Rubric::find()->roots()->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'rubrics' => $rubrics
        ]);
    }

}
