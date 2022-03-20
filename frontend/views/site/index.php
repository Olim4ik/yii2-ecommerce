<?php

/* @var $this yii\web\View */

/* @var ActiveDataProvider $dataProvider
 */
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->title = 'My Yii Application';
?>


<div class="site-index ">
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_product_item',
        'layout' => '{summary}<div class="row">{items}</div>{pager}',
        'options' => [
            'class' => 'row'
        ],
        'itemOptions' => [
            'class' => 'col-xl-3 mb-5'
        ],
        'pager' => [
            'class' => \yii\bootstrap4\LinkPager::class
        ]
    ]) ?>
</div>
