<?php
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
?>
<div class="container-fluid">
  <div class="mb-5">
    <h1 class="display-4 d-inline" ><?= $collection->name ?></h1>
    <button
      id="editFormBtn"
      class="btn btn-primary"
      style="vertical-align: text-bottom;"
      data-toggle="modal" data-target="#editForm"
      >
      Edit
    </button>
    <?php
        $editForm = ActiveForm::begin(
          [
            'action' => ['collection/delete',"id"=>$collection->id],
            'method' => 'delete',
            'options' => [
              'class' => 'search-form d-inline'
            ]
          ]);
      ?>
      <?= Html::submitButton("Delete", [
        'class' => "btn btn-danger",
        'id'=>'delete',
        'style' => 'vertical-align: text-bottom;'
      ]); ?>
      <?php ActiveForm::end(); ?>
      <button
        class="btn btn-info"
        style="vertical-align: text-bottom;"
        data-toggle="modal" data-target="#slider"
      >
      View Slideshow
    </button>
    <?php
        $downloadForm = ActiveForm::begin(
          [
            'action' => ['collection/download',"id"=>$collection->id],
            'options' => [
              'class' => 'search-form d-inline'
            ]
          ]);
      ?>
      <?= Html::submitButton("Download", [
        'class' => "btn btn-dark",
        'id'=>'delete',
        'style' => 'vertical-align: text-bottom;'
      ]); ?>
      <?php ActiveForm::end(); ?>

  </div>
	<div class="row">
		<?php foreach ($collection->photos as $photo): ?>
			<div class='wrap-image'>
				<img class="col mb-3" src="<?= $photo->photo_path ?>">
				<button type="button" class='btn btn-danger remove'
				 data-collection="<?= $collection->id ?>"
				 data-photo="<?= $photo->photo_id ?>">x</button>
			</div>
		<?php endforeach; ?>
	</div>
</div>

<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Collection Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php
            $editForm = ActiveForm::begin(
              [
                'action' => ['collection/update',"id"=>$collection->id],
                'options' => [
                  'class' => 'search-form'
                ]
              ]);
          ?>
          <?= $editForm->field($collection, 'name')->textInput(['style'=>'width:400px'])->label('Name'); ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <?= Html::submitButton("Update", ['class' => "btn btn-primary", 'id'=>'update']); ?>
      </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>
<?= \Yii::$app->view->renderFile(
      Yii::getAlias('@app') . '/views/layouts/slideshow.php',
      ['collection' => $collection]
    ); ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">
	let removePhotoUrl = <?php echo json_encode(Url::to(['collection/remove'])); ?>;

	$( document ).ready(function($) {
		$(".remove").click(function(e) {
			let elementToRemove = $(this).parent();
			let data = {
				collection_id: $( this ).data( 'collection' ),
				photo_id: $( this ).data( 'photo' )
			}
			$.ajax({
                url: removePhotoUrl,
                type: 'post',
                dataType: 'json',
                data: data
            })
            .done(function(response) {
            	elementToRemove.remove();
            })
            .fail(function() {
                alert("error");
            });
		});
	});
</script>

<style type="text/css">
.wrap-image {
  position: relative;
  width: 30%;
}

.wrap-image img {
  width: 100%;
  height: auto;
}

.wrap-image .btn {
  position: absolute;
  top: 14%;
  left: 85%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  color: white;
  font-size: 16px;
  padding: 8px 18px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}
</style>
