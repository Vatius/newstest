<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\rest\Controller;
use yii\web\Response;

use app\models\Rubric;

class RubricController extends Controller {

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
        $roots = Rubric::find()->roots()->all();

        $allRubrics = [];

        function createTree($rubric, $left, $right) {
            $tree = [];
            foreach ($rubric as $item) {
                if ($item['lft'] > $left && $item['rgt'] < $right) {
                    $tree[] = ['id' => $item['id'], 'name' => $item['name'], 'child' => createTree($rubric, $item['lft'], $item['rgt'])];
                    $left = $item['rgt'];
                }
            }
            return $tree;
        }

        foreach ($roots as $root) {
            $rubrics = $root->children()->all();
            $allRubrics[] = ['id' => $root['id'], 'name' => $root['name'], 'child' => createTree($rubrics, $root['lft'], $root['rgt'])];
        }

        return $allRubrics;
    }

    public function actionView($id)
    {
        $model = Rubric::findOne($id);

        if (is_null($model)) {
            throw new \yii\web\NotFoundHttpException();
        }

        return $model;
    }

    public function actionCreate()
    {
        $data = Yii::$app->getRequest()->getBodyParams();

        if (!$data['parent']) {
            //is root
            $rubric = new Rubric(['name' => $data['name'], 'tree' => 1]);
            $rubric->makeRoot();
            return $rubric;
        }

        $parentRubric = Rubric::findOne($data['parent']);

        if (is_null($parentRubric)) {
            return [
                'error' => 'parent rubric not found'
            ];
        }

        $newRubric = new Rubric(['name' => $data['name']]);
        $newRubric->prependTo($parentRubric);

        return $newRubric;
    }

    public function actionUpdate($id)
    {
        $model = Rubric::findOne($id);

        if (is_null($model)) {
            throw new \yii\web\NotFoundHttpException();
        }

        $data = Yii::$app->getRequest()->getBodyParams();

        $model->name = $data['name'];
        $model->save();

        return $model;
    }

    public function actionDelete($id)
    {
        $model = Rubric::findOne($id);

        if (is_null($model)) {
            throw new \yii\web\NotFoundHttpException();
        }

        $model->delete();

        return [
            'success' => true
        ];
    }

}