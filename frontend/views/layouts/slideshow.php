<?php
  $this->registerCssFile('@web/css/slideshow.css');
  $this->registerJsFile('@web/js/slideshow.js');
?>
<div class="modal fade" id="slider" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <!-- slider -->
        <div class="slideshow-inner">
          <?php foreach ($collection->photos as $photo): ?>
          <div class="mySlides">
            <img src="<?= $photo->photo_path ?>" style='width: 100%;height: 100%' alt="sally lightfoot crab"/>
          </div>
          <?php endforeach; ?>
        </div>
        <button type="button" class='btn btn-primary play' onclick="control()">
        <i class="fa fa-play"></i> /
        <i class="fa fa-stop"></i>
      </button>
        <a class="prev" onclick='plusSlides(-1)'>&#10094;</a>
        <a class="next" onclick='plusSlides(1)'>&#10095;</a>
      </div>
      <div style='text-align: center; display: none'>
      <?php for ($i=1;$i<=count($collection->photos);$i++): ?>
        <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
      <?php endfor; ?>
      </div>
      <!-- slider -->
      </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style type="text/css">


.play {
  position: absolute;
  top: 90%;
  left: 92%;
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