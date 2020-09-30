<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

class MainController extends Controller {

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
        return [
            'success' => true,
            'data' => 'hello from api'
        ];
    }

    public function actionRubric()
    {
        return false;
    }

    public function actionView()
    {
        return false;
    }

}