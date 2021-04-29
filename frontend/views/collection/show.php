<?php
use yii;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;
?>
<div class="container-fluid">
  <div class="mb-5">
    <h1 class="display-4 d-inline" ><?= $collection->name ?></h1>
    <button
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

<div class="modal fade" id="slider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- slider -->
        <div class="slideshow-inner">
          <?php foreach ($collection->photos as $photo): ?>
          <div class="mySlides ">
            <img src="<?= $photo->photo_path ?>" style='width: 100%;height: 100%' alt="sally lightfoot crab"/>
          </div>
          <?php endforeach; ?>
        </div>
        <a class="prev" onclick='plusSlides(-1)'>&#10094;</a>
        <a class="next" onclick='plusSlides(1)'>&#10095;</a>
      </div>
      <br/>
      <div style='text-align: center;'>
      <?php for ($i=1;$i<=count($collection->photos);$i++): ?>
        <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
      <?php endfor; ?>
      </div>
      <button class="btn btn-light">Start/Stop</button>
      <!-- slider -->
      </div>
    </div>
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

.mySlides {
  display: none;
  height: 600px;
  border: solid 1px black;

}

.prev,
.next {
    cursor: pointer;
    position: absolute;
    top: 50%;
    width: auto;
    margin-top: -22px;
    padding: 16px;
    color: #222428;
    font-weight: bold;
    font-size: 30px;
    transition: .6s ease;
    border-radius: 0 3px 3px 0
}

.next {
    right: -50px;
    border-radius: 3px 3px 3px 3px
}

.prev {
    left: -50px;
    border-radius: 3px 3px 3px 3px
}

.prev:hover,
.next:hover {
    color: #f2f2f2;
    background-color: rgba(0, 0, 0, 0.8)
}

.text {
    color: #f2f2f2;
    font-size: 15px;
    padding-top: 12px;
  padding-bottom: 12px;
    position: absolute;
    bottom: 0;
    width: 100%;
    text-align: center;
    background-color: #222428
}

.numbertext {
    color: #f2f2f2;
    font-size: 12px;
    padding: 8px 12px;
    position: absolute;
    top: 0
}

.dot {
    cursor: pointer;
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    transition: background-color .6s ease
}

.active,
.dot:hover {
    background-color: #717171
}

</style>

<script type="text/javascript">
var slideIndex = 1;

var myTimer;

var slideshowContainer;

window.addEventListener("load",function() {
    showSlides(slideIndex);
    myTimer = setInterval(function(){plusSlides(1)}, 4000);

    //COMMENT OUT THE LINE BELOW TO KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME
    slideshowContainer = document.getElementsByClassName('slideshow-inner')[0];

    //UNCOMMENT OUT THE LINE BELOW TO KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME
    // slideshowContainer = document.getElementsByClassName('slideshow-container')[0];

    slideshowContainer.addEventListener('mouseenter', pause)
    slideshowContainer.addEventListener('mouseleave', resume)
})

// NEXT AND PREVIOUS CONTROL
function plusSlides(n){
  clearInterval(myTimer);
  if (n < 0){
    showSlides(slideIndex -= 1);
  } else {
   showSlides(slideIndex += 1);
  }

  //COMMENT OUT THE LINES BELOW TO KEEP ARROWS PART OF MOUSEENTER PAUSE/RESUME

  if (n === -1){
    myTimer = setInterval(function(){plusSlides(n + 2)}, 4000);
  } else {
    myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
  }
}

//Controls the current slide and resets interval if needed
function currentSlide(n){
  clearInterval(myTimer);
  myTimer = setInterval(function(){plusSlides(n + 1)}, 4000);
  showSlides(slideIndex = n);
}

function showSlides(n){
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}

pause = () => {
  clearInterval(myTimer);
}

resume = () =>{
  clearInterval(myTimer);
  myTimer = setInterval(function(){plusSlides(slideIndex)}, 4000);
}
</script>