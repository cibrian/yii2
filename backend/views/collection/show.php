<?php
use yii;
use yii\helpers\Url;
?>
<div class="container-fluid">
<h1 class="display-4 mb-5"><?= $collection->name ?></h1>
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