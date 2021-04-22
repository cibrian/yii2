<?php

namespace backend\models;

use Yii;
use yii\base\Model;


class UnsplashSearchForm extends Model
{
    public $query;

    public function rules()
    {
        return [
            ['query','required'],
            ['query','string'],
        ];
    }

}
