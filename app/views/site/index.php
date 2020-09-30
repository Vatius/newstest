<?php

/* @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider;
 * @var $rubrics [];
 */

use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Новостная лента';

?>
<div class="site-index">
    <div class="form-froup">
        <label for="rubrics">Select rubric: </label>
        <select name="rubrics" id="rubrics-select">
            <?php foreach ($rubrics as $rubric): ?>
                <option value="<?= $rubric->id ?>"><?= $rubric->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <br>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'text',
            [
                'label' => 'Rubrics',
                'content' => function ($data) {
                    $arr = [];
                    foreach ($data->rubrics as $item) {
                        $arr[] = $item['name'];
                    }
                    return implode(", ", $arr);
                },
            ],
            [
                'attribute' => 'created_at',
                'format' =>  ['date', 'd.m.Y H:m'],
            ]
        ],
    ]);?>
    <?php Pjax::end(); ?>
</div>
