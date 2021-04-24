<?php
use yii;
?>
<div class="container-fluid">
<h1 class="display-4 mb-5"><?= $collection->name ?></h1>
	<div class="row">
		<?php foreach ($collection->photos as $photo): ?>
			<img class="col mb-3" src="<?= $photo->photo_path ?>">
		<?php endforeach; ?>
	</div>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>