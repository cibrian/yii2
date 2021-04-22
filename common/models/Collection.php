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
class Collection extends ActiveRecord
{

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Retrieve all related photos.
     */
    public function getPhotos()
    {
        return $this->hasMany(CollectionPhoto::className(), ['collection_id' => 'id']);
    }

}
