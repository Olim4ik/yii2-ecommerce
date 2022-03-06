<?php

namespace common\models\query;

use common\models\Products;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\Products]].
 *
 * @see \common\models\Products
 */
class ProductsQuery extends ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Products[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Products|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
