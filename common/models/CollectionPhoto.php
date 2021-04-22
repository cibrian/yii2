<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Collection model
 *
 * @property integer $id
 * @property string $name
 * @property integer $user_id
 */
class CollectionPhoto extends ActiveRecord {

	public static function primaryKey()
    {

        return ['photo_id', 'collection_id'];

    }
}
