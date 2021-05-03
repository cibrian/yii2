<?php
use common\models\User;
use yii;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider = new ActiveDataProvider([
    'query' => User::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'username',
        'email',
        'is_admin:boolean',
        'created_at:datetime',
        [
       		'label' => 'Edit',
       		'format' => 'raw',
       		'value' => function ($data) {
            	return Html::a(Html::encode("Edit"),Url::to(['user/edit','id'=>$data->id]));
       		},
    	],
    ],
]);

?>
