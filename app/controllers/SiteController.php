<?php

namespace app\controllers;

use app\models\News;
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
        $model = News::find()->with('rubrics')->limit(20)->all();

        return $this->render('index', [
            'model' => $model
        ]);
    }

}
