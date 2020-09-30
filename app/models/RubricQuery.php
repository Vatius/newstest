<?php

namespace app\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;
use yii\db\ActiveQuery;

class RubricQuery extends ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::class,
        ];
    }
}