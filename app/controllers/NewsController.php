<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use app\models\News;
use app\models\NewsRubric;

class NewsController extends Controller {

    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => 'yii\filters\Cors',
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET','POST'],
                    'Access-Control-Request-Headers' => ['*'],
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find(),
        ]);

        $pagination = [
            'totalCount' => $dataProvider->getTotalCount(),
            'pageSize' => $dataProvider->pagination->pageSize,
        ];

        return [
            '_pagination' => $pagination,
            'news' => $dataProvider
        ];
    }

    public function actionView($id)
    {
        $model = News::find()->with('rubrics')->where(['id' => $id])->one();

        if (is_null($model)) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $model;
    }

    public function actionCreate()
    {
        $data = Yii::$app->getRequest()->getBodyParams();

        $model = new News();
        $model->title = $data['title'];
        $model->text = $data['text'];

        if(!$model->validate()) {
            return [
                'success' => false,
                'error' => 'not valid data'
            ];
        }

        $model->save();

        $rubrics = $data['rubrics'];
        foreach ($rubrics as $item) {
            $newsRubric = new NewsRubric();
            $newsRubric->news_id = $model->id;
            $newsRubric->rubric_id = $item;
            if ($newsRubric->validate()) {
                $newsRubric->save();
            } else {
                return [
                    'success' => false,
                    'error' => 'can not add rubric'
                ];
            }

        }

        return $model;
    }

    public function actionUpdate($id)
    {
        $model = News::findOne($id);

        if (is_null($model)) {
            throw new \yii\web\NotFoundHttpException();
        }

        $data = Yii::$app->getRequest()->getBodyParams();

        $model->title = $data['title'];
        $model->text = $data['text'];

        if(!$model->validate()) {
            return [
                'success' => false,
                'error' => 'not valid data'
            ];
        }

        $model->save();

        return [
            'success' => true
        ];
    }

    public function actionDelete($id)
    {
        $model = News::findOne($id);

        if (is_null($model)) {
            throw new \yii\web\NotFoundHttpException();
        }

        $model->delete();

        return [
            'success' => true
        ];
    }

}