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
          <div class="mySlides ">
            <img src="<?= $photo->photo_path ?>" style='width: 100%;height: 100%' alt="sally lightfoot crab"/>
          </div>
          <?php endforeach; ?>
        </div>
        <a class="prev" onclick='plusSlides(-1)'>&#10094;</a>
        <a class="next" onclick='plusSlides(1)'>&#10095;</a>
      </div>
      <button class="btn btn-light" onclick="control()">Start/Stop</button>
      <div style='text-align: center; display: none'>
      <?php for ($i=1;$i<=count($collection->photos);$i++): ?>
        <span class="dot" onclick="currentSlide(<?= $i ?>)"></span>
      <?php endfor; ?>
      </div>
      <!-- slider -->
      </div>
    </div>
</div>