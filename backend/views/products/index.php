<?php

use yii\grid\SerialColumn;
use common\models\Products;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],

            [
                'attribute' => 'image',
                'content' => static function($model) {
                    /** @var $model Products */
                    return Html::img($model->getImageUrl(), ['width' => '100px']);
                },

            ],
            'description:html',
	        'name',
	        [
		        'attribute' => 'price',

		        'format' => [
			        'currency',
			        '$',
		        ],
	        ],
	        [
                'attribute' => 'status',
                'content' => static function($model) {
	                /** @var $model Products */
                    return Html::tag('span', $model->status ? 'Active' : 'Draft', [
                            'class' => $model->status ? 'badge badge-success' : 'badge badge-danger'
                    ]);
                }
            ],
            [
                'attribute' => 'created_at',
                'format' => ['datetime'],
                'contentOptions' => ['style' => 'white-space: nowrap']
            ],
	        [
		        'attribute' => 'updated_at',
		        'format' => ['datetime'],
		        'contentOptions' => ['style' => 'white-space: nowrap']
	        ],
	        //'created_by',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => static function ($action, Products $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
