
<link rel="stylesheet" href="<?=base_url()?>assets/cropperjs/css/cropper.css">
<link rel="stylesheet" href="<?=base_url()?>assets/cropperjs/css/main.css">

<script src="<?=base_url()?>assets/bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?=base_url()?>assets/cropperjs/js/cropper.js"></script>
<script src="<?=base_url()?>assets/cropperjs/js/main.js"></script>


 <!-- Content -->
 <div class="container">
   
    <div id="boxCropper" class="mt-5" style="display:none;">

      <div class="row" style="width:100%;">
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="img-container">
            <img src="" alt="Image" style="display:none;">
          </div>
        </div>
      
      </div>
	
      <div class="row" id="actions">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center docs-buttons">

          <input type="hidden" class="form-control" id="dataX" placeholder="x">
          <input type="hidden" class="form-control" id="dataY" placeholder="y">
          <input type="hidden" class="form-control" id="dataWidth" placeholder="width">
          <input type="hidden" class="form-control" id="dataHeight" placeholder="height">
          <input type="hidden" class="form-control" id="dataRotate" placeholder="rotate">
          <input type="hidden" class="form-control" id="dataScaleX" placeholder="scaleX">
          <input type="hidden" class="form-control" id="dataScaleY" placeholder="scaleY">

          <!-- zoom -->
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom +">
              <span class="docs-tooltip" data-toggle="tooltip" title="Zoom +">
                <span class="fa fa-search-plus"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom -">
              <span class="docs-tooltip" data-toggle="tooltip" title="Zoom -">
                <span class="fa fa-search-minus"></span>
              </span>
            </button>
          </div>
          <!-- / zoom -->

          <!-- move -->
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
              <span class="docs-tooltip" data-toggle="tooltip" title="Mover para esquerda">
                <span class="fa fa-arrow-left"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
              <span class="docs-tooltip" data-toggle="tooltip" title="Mover para direita">
                <span class="fa fa-arrow-right"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
              <span class="docs-tooltip" data-toggle="tooltip" title="Mover para cima">
                <span class="fa fa-arrow-up"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
              <span class="docs-tooltip" data-toggle="tooltip" title="Mover para baixo">
                <span class="fa fa-arrow-down"></span>
              </span>
            </button>
          </div>
          <!-- / move -->

          <!-- rotate -->
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
              <span class="docs-tooltip" data-toggle="tooltip" title="Rotacioanr para esquerda">
                <span class="fa fa-undo-alt"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
              <span class="docs-tooltip" data-toggle="tooltip" title="Rotacioanr para direita">
                <span class="fa fa-redo-alt"></span>
              </span>
            </button>
          </div>
          <!-- / rotate -->
          
          <!-- flip -->
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
              <span class="docs-tooltip" data-toggle="tooltip" title="Espelhar Horizontal">
                <span class="fa fa-arrows-alt-h"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
              <span class="docs-tooltip" data-toggle="tooltip" title="Espelhar Vertical">
                <span class="fa fa-arrows-alt-v"></span>
              </span>
            </button>
          </div>
          <!-- / flip -->

          <!-- reset -->
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
              <span class="docs-tooltip" data-toggle="tooltip" title="Desfazer alterações">
                <span class="fa fa-sync-alt"></span>
              </span>
            </button>
          </div>
          <!-- / reset -->
         
          <div class="btn-group btn-group-crop" >
            <button type="button" class="btn btn-success" data-method="getCroppedCanvas" ontouchstart="loading()" id="usar_img" data-option="{ &quot;maxWidth&quot;: 4096, &quot;maxHeight&quot;: 4096 }">
            Usar Imagem
            </button>
          </div>

          <!-- Show the cropped image in modal -->
          <div class="modal fade docs-cropped" id="getCroppedCanvasModal" role="dialog" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="getCroppedCanvasTitle">Confirme</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer" style="display:flex;justify-content:space-between; align-items: center; align-content: center; align-self:stretch">

                  <div>
                    <div class="alert mt-3 px-3 py-3" id="responseUpload" style="text-align:left !important"></div>
                  </div>
                  
                  <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancel" reload="false" >Fechar</button>
                    <button type="button" class="btn btn-primary" id="confirm" href="javascript:void(0);">Confirmo</button>
                  </div>

                  
                </div>
              </div>
            </div>
          </div><!-- /.modal -->

        </div><!-- /.docs-buttons -->

        <div class="col-md-3 docs-toggles">
          <!-- <h3>Toggles:</h3> -->
        

        </div><!-- /.docs-toggles -->
      </div>


    </div>

  </div>




  <script>
    function loading() {
      document.getElementById("usar_img").innerHTML = "<i class='fas fa-spinner fa-spin'></i> Aguarde";
    }
  </script>

  <script>
    $(function(){
    
      getOptionSelected();
 
      $("#selectOptionStep").change(function(e){
        getOptionSelected();
      });


      $("input[name='file']").change(function(e){
        $("#boxCropper").show();
      });


      $("#confirm").click(function(e){
        $("#confirm").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
      });

      $("#closeModal").click(function(){
        document.getElementById("usar_img").innerHTML = "Usar Imagem";
        if($("#cancel").attr('reload') == "true"){
          location.reload();
        }
      });

      $("#cancel").click(function(){
        document.getElementById("usar_img").innerHTML = "Usar Imagem";
        if($(this).attr('reload') == "true"){
          location.reload();
        }
      });

      function getOptionSelected() {
        var value = $("#selectOptionStep :selected").val();
        var text = $("#selectOptionStep :selected").text();
        if(text == "Frente" || text == "Verso"){
          $("#subTitleOption").text(text).show();
        }
        $("#fileType").val(value);
      }

    });
  </script>

