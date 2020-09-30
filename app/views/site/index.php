<?php

/* @var $this yii\web\View
 * @var $dataProvider yii\data\ActiveDataProvider;
 * @var $rubrics [];
 */

use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Новостная лента';

$js = <<<JS
$.ajax({
  type: "GET",
  url: "/rubric",
  success: data => {
      function getTree(element) {
          let res = '';
          if (element.length > 0) {
              element.forEach(it => {
                  res += "<li><a href=\"/category/" + it['id'] + "\">" + it['name'] + "</a>" + getTree(it['child']) + "</li>";
              });
          }
          return "<ul>"+res+"</ul>";
      }
      $("#rubrics").append(getTree(data));
  }
});
JS;

$this->registerJs($js);

?>
<div class="site-index">
    <div class="btn btn-info" onClick="$('#rubrics').toggle();">Rubrics (hide/show)</div>
    <div id="rubrics" style="margin: 1em 0"></div>
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
