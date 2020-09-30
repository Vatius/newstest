<?php

namespace app\controllers;

use app\models\News;
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

}
