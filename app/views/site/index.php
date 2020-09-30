<?php

/* @var $this yii\web\View
 * @var $model app\models\News
 */

$this->title = 'Новостная лента';
$css = <<<CSS
    .rubric {
        display: inline-block;
        padding: 0 10px;
        color: #0b72b8;
        border-right: 1px #0d3349 solid;
    }
    .rubric:last-child {
        border-right: none;
    }
    #load-more-btn {
     color: #2e3436;   
    }
CSS;

$js = <<<JS
$("#load-more-btn").click(function(event) {
    event.preventDefault();
});
JS;


$this->registerCss($css);
$this->registerJs($js);

?>
<div class="site-index">
    <?php foreach ($model as $item): ?>
    <h2><?= $item->title ?></h2>
    <p> <?= $item->text ?></p>
    <p>Дата публикации: <?= \Yii::$app->formatter->asDatetime($item->created_at, 'php:d.m.Y H:i') ?>.
        Рубрики: <?php foreach ($item->rubrics as $rubric): ?>
        <span class="rubric"><?= $rubric->name ?></span>
        <?php endforeach; ?>
    </p>
    <?php endforeach; ?>
    <a href="#" id="load-more-btn">Показать ещё</a>
</div>
