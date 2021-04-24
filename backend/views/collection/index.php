<?php
use yii;
use yii\helpers\Url;
?>

<div class="container-fluid">
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


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>