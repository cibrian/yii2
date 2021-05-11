<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class CollectionForm extends Model
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['name', 'required'],
        ];
    }

}
