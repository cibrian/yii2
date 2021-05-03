<?php
use yii;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$form = ActiveForm::begin(
  [
      'action' => ['user/edit',"id"=>$user->id],
      'method' => 'post',
      'options' => [
        'class' => 'search-form d-inline'
      ]
  ]
);

echo $form->field($user,'username');
echo $form->field($user,'email');
echo $form->field($user,'is_admin')->checkbox();

echo Html::submitButton("Update",
  [
        'class' => "btn btn-primary",
  ]
);

ActiveForm::end();

?>