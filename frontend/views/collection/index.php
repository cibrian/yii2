<?php
use yii;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'Collections';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
	<div class="text-right my-2">
		<button class="btn btn-primary" data-toggle="modal" data-target="#createForm">New Collection</button>
	</div>
	<div class="row">
		<?php foreach ($user->collections as $collection): ?>
		<div class="card col px-0 mx-2" style="width: 18rem;">
			<div id="<?= $collection->id ?>" class="carousel slide" data-ride="carousel">
			  	<div class="carousel-inner">
			  		<?php foreach ($collection->photos as $photo): ?>
					    <div class="carousel-item <?= ($collection->photos[0]==$photo)? 'active':'' ?>">
					      <img src="<?= $photo->photo_path ?>" class="d-block w-100" alt="...">
					    </div>
					<?php endforeach; ?>
			 	</div>
			  	<a class="carousel-control-prev" href="#<?= $collection->id ?>" role="button" data-slide="prev">
			    	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			    	<span class="sr-only">Previous</span>
			  	</a>
			  	<a class="carousel-control-next" href="#<?= $collection->id ?>" role="button" data-slide="next">
			    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
			    	<span class="sr-only">Next</span>
			  	</a>
			</div>
		  <div class="card-body">
		    <h5 class="card-title"><?= $collection->name ?></h5>
		    <a href="<?=Url::to(['collection/show','id'=>$collection->id]) ?>" class="btn btn-primary">Edit Collection</a>
		  </div>
		</div>
		<?php endforeach; ?>
	</div>
</div>

<div class="modal fade" id="createForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create a new collection</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <?php
            $createForm = ActiveForm::begin(
              [
                'action' => ['collection/create'],
                'options' => [
                  'class' => 'search-form'
                ]
              ]);
          ?>
          <?= $createForm->field($model, 'name')->textInput(['style'=>'width:400px'])->label('Name'); ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <?= Html::submitButton("Create", ['class' => "btn btn-primary", 'id'=>'create']); ?>
      </div>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>