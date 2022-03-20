<?php

use common\models\Products;

/* @var Products $model
 *
 */
?>
<style>
    a {
        text-decoration: none !important;
    }
</style>

    <div class="card h-100">
        <!-- Sale badge-->
        <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
        <!-- Product image-->
        <img class="card-img-top" src="<?= $model->getImageUrl() ?>" alt="..."/>
        <!-- Product details-->
        <div class="card-body p-3">
            <div class="text-center">
                <!-- Product name-->
                <h5 class="fw-bolder"><a href=""><?= $model->name ?></a></h5>
                <!-- Product reviews-->
                <div class="d-flex justify-content-center small text-warning">
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                    <div class="bi-star-fill"></div>
                </div>
                <!-- Product price-->
                <span class="text-muted text-decoration-line-through fw-bolder"><?= Yii::$app->formatter->asCurrency($model->price) ?></span>
                <div class="card-text">
					<?= $model->getShortDescription() ?>
                </div>
            </div>

        </div>
        <!-- Product actions-->
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">Add to cart</a></div>
        </div>
    </div>

