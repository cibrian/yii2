<?php
namespace common\models;

use Yii;
use common\models\Collection;
use common\models\CollectionForm;
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
            ['name', 'uniqueness'],
        ];
    }

    public function uniqueness($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->isDuplicated($this->name)) {
                $this->addError($attribute, 'Duplicated name.');
                return false;
            }
            return true;
        }
    }

    public function isDuplicated($name)
    {
        return Collection::find()->where([
            'user_id' => Yii::$app->user->identity->id,
            'name' => $name,
        ])->exists();
    }

}
