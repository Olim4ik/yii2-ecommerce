<?php

namespace common\models;

use Cassandra\Time;
use common\models\query\CartItemsQuery;
use common\models\query\OrderItemsQuery;
use common\models\query\ProductsQuery;
use common\models\query\UserQuery;
use MongoDB\BSON\Timestamp;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $image
 * @property float $price
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 *
 * @property CartItems[] $cartItems
 * @property User $createdBy
 * @property OrderItems[] $orderItems
 * @property User $updatedBy
 */
class Products extends \yii\db\ActiveRecord
{
	/**
	 * @var UploadedFile
	 */
	public $imageFile;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%products}}';
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::class,
			BlameableBehavior::class
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'price', 'status'], 'required'], #, 'image'
			[['description'], 'string'],
			[['price'], 'number'],
			[['status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
			[['name'], 'string', 'max' => 255],
			[['imageFile'], 'image', 'extensions' => 'png, jpg, jpeg, webp', 'maxSize' => 10 * 1024 * 1024],
			[['image'], 'string', 'max' => 2000],
			[['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
			[['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'image' => 'Product Image',
			'imageFile' => 'Product Image',
			'price' => 'Price',
			'status' => 'Published',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
			'created_by' => 'Created By',
			'updated_by' => 'Updated By',
		];
	}

	/**
	 * Gets query for [[CartItems]].
	 *
	 * @return ActiveQuery
	 */
	public function getCartItems()
	{
		return $this->hasMany(CartItems::className(), ['product_id' => 'id']);
	}

	/**
	 * Gets query for [[CreatedBy]].
	 *
	 * @return ActiveQuery
	 */
	public function getCreatedBy()
	{
		return $this->hasOne(User::className(), ['id' => 'created_by']);
	}

	/**
	 * Gets query for [[OrderItems]].
	 *
	 * @return ActiveQuery
	 */
	public function getOrderItems()
	{
		return $this->hasMany(OrderItems::className(), ['product_id' => 'id']);
	}

	/**
	 * Gets query for [[UpdatedBy]].
	 *
	 * @return ActiveQuery
	 */
	public function getUpdatedBy()
	{
		return $this->hasOne(User::className(), ['id' => 'updated_by']);
	}

	/**
	 * {@inheritdoc}
	 * @return ProductsQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new ProductsQuery(static::class);
	}

	public function save($runValidation = true, $attributeNames = null)
	{
		if ($this->imageFile) {
			$this->image = '/products/' . Yii::$app->security->generateRandomString() . '/' . $this->imageFile->name;
		}

		$transaction = Yii::$app->db->beginTransaction();
		$ok = parent::save($runValidation, $attributeNames);

		if ($ok && $this->imageFile ) {
			$fullPath = Yii::getAlias('@frontend/web/storage' . $this->image);
			$dir = dirname($fullPath);
			if (!FileHelper::createDirectory($dir) | !$this->imageFile->saveAs($fullPath)) {
				$transaction->rollBack();
				return false;
			}

		}
		$transaction->commit();
		return $ok;
	}

	public function getImageUrl()
	{
		if ($this->image) {
			return Yii::$app->params['frontendUrl'] . '/storage/' . $this->image;
		}
		return Yii::$app->params['frontendUrl'].'/img/no_img.svg';
	}
}
