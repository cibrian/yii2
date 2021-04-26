<?php
use yii;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->title = 'Home';
?>

<?php
$form = ActiveForm::begin([
    'action' => ['unsplash/search'],
    'options' => [
        'class' => 'search-form'
    ]
]);

?>
    <?= $form->field($model, 'query')->textInput(['style'=>'width:400px']); ?>
    <?= Html::button("Search", ['class' => "btn btn-primary", 'id'=>'search']); ?>
    <div class="container">
      <div id="photos" class="row" style="margin-top:15px"></div>
    </div>
  <div id="collectionModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add to Collection</h4>
        </div>
        <div class="modal-body">
          <?php foreach ($user['collections'] as $collection): ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="<?= $collection->id ?>" id="<?= $collection->id ?>">
              <label class="form-check-label" for="<?= $collection->id ?>">
                <?= $collection->name ?>
              </label>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>

    </div>
  </div>

<?php ActiveForm::end(); ?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script type="text/javascript">
    var collections = <?php echo $collections ?>;
    var updateCollectionUrl = <?php echo json_encode(Url::to(['collection/update'])); ?>;
    var chosenImage = "";
    var chosenImageUrl = "";
    $( document ).ready(function($) {
        $("#search").click(function(e) {
            e.preventDefault(e);
            var data = $('.search-form').serializeArray();
            var url = $('.search-form').attr('action');
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: data
            })
            .done(function(response) {
                $("#photos").empty();
                for (photo in response.photos) {
                    let photoUrl = response.photos[photo].urls.small;
                    let photoId = response.photos[photo].id;
                    let photoDescription = response.photos[photo].description;

                    $("#photos").append("<div class='card m-4' style='width: 20rem;'><img class='card-img-top' src='"+photoUrl+"'><div class='card-body text-center'><p class='card-text text-capitalize'>"+photoDescription+"</p><button id='"+photoId+"' data-photo-path='"+photoUrl+"' class='btn btn-primary btn-image' onclick='return false;' data-toggle='modal' data-target='#collectionModal'>Add to Collection</button></div></div>");
                }
                $(".btn-image").bind("click",function(e) {
                  chosenImage = $(this).attr('id');
                  chosenImageUrl = $(this).data('photo-path');
                  $("input:checkbox").prop( "checked", false);
                  let photoId = $(this).attr('id');
                    for(collection in collections){
                      if(collections[collection].photos.find(photo => photo === photoId)){
                        $(`#${collections[collection].id}`).prop( "checked", true );
                      }
                    }
                });
            })
            .fail(function() {
                alert("error");
            });

        });
        $(".form-check-input").change(function(e) {
          let data = {
            photo_id: chosenImage,
            collection_id: $(this).attr('id'),
            photo_path: chosenImageUrl
          };
          $.ajax({
                url: updateCollectionUrl,
                type: 'post',
                dataType: 'json',
                data: data,
            }).done(function(response){
              collections = response.collections;
              console.log(collections);
            }).fail(function() {
                alert("error");
            });
        });
    });
</script>