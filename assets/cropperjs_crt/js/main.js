window.onload = function () {
  'use strict';

  var Cropper = window.Cropper;
  var URL = window.URL || window.webkitURL;
  var container = document.querySelector('.img-container');
  var image = container.getElementsByTagName('img').item(0);
  // var download = document.getElementById('download');
  var actions = document.getElementById('actions');
  var dataX = document.getElementById('dataX');
  var dataY = document.getElementById('dataY');
  var dataHeight = document.getElementById('dataHeight');
  var dataWidth = document.getElementById('dataWidth');
  var dataRotate = document.getElementById('dataRotate');
  var dataScaleX = document.getElementById('dataScaleX');
  var dataScaleY = document.getElementById('dataScaleY');
  var avatar = document.getElementById('avatar');

  var options = {
    aspectRatio: 'NaN',
    preview: '.img-preview',
    responsive: true,
    modal: true,
    background: true,
    autoCrop: true,
    viewMode: 1,
    initialAspectRatio: 'NaN',
    aspectRatio: 'NaN',
    autoCropArea: 0.95,
    
    ready: function (e) {
     // console.log(e.type);
    },
    cropstart: function (e) {
     // console.log(e.type, e.detail.action);
    },
    cropmove: function (e) {
      // console.log(e.type, e.detail.action);
    },
    cropend: function (e) {
      // console.log(e.type, e.detail.action);
    },
    crop: function (e) {
      var data = e.detail;
      
      //console.log(e.type);

      dataX.value = Math.round(data.x);
      dataY.value = Math.round(data.y);
      dataHeight.value = Math.round(data.height);
      dataWidth.value = Math.round(data.width);
      dataRotate.value = typeof data.rotate !== 'undefined' ? data.rotate : '';
      dataScaleX.value = typeof data.scaleX !== 'undefined' ? data.scaleX : '';
      dataScaleY.value = typeof data.scaleY !== 'undefined' ? data.scaleY : '';
    },
    zoom: function (e) {
     // console.log(e.type, e.detail.ratio);
    }
  };
  var cropper = new Cropper(image, options);
  var originalImageURL = image.src;
  var uploadedImageType = 'image/jpeg';
  var uploadedImageName = 'cropped.jpg';
  var uploadedImageURL;

  // Tooltip
  $('[data-toggle="tooltip"]').tooltip();

  // Buttons
  if (!document.createElement('canvas').getContext) {
    $('button[data-method="getCroppedCanvas"]').prop('disabled', true);
  }

  if (typeof document.createElement('cropper').style.transition === 'undefined') {
    $('button[data-method="rotate"]').prop('disabled', true);
    $('button[data-method="scale"]').prop('disabled', true);
  }

  // Download
  /*
  if (typeof download.download === 'undefined') {
    download.className += ' disabled';
    download.title = 'Your browser does not support download';
  }
  */

  // Options
  actions.querySelector('.docs-toggles').onchange = function (event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropBoxData;
    var canvasData;
    var isCheckbox;
    var isRadio;

    if (!cropper) {
      return;
    }

    if (target.tagName.toLowerCase() === 'label') {
      target = target.querySelector('input');
    }

    isCheckbox = target.type === 'checkbox';
    isRadio = target.type === 'radio';

    if (isCheckbox || isRadio) {
      if (isCheckbox) {
        options[target.name] = target.checked;
        cropBoxData = cropper.getCropBoxData();
        canvasData = cropper.getCanvasData();

        options.ready = function () {
          //console.log('ready');
          cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
        };
      } else {
        options[target.name] = target.value;
        options.ready = function () {
          //console.log('ready');
        };
      }

      // Restart
      cropper.destroy();
      cropper = new Cropper(image, options);
    }
  };

  // Methods
  actions.querySelector('.docs-buttons').onclick = function (event) {
    var e = event || window.event;
    var target = e.target || e.srcElement;
    var cropped;
    var result;
    var input;
    var data;

    if (!cropper) {
      return;
    }

    while (target !== this) {
      if (target.getAttribute('data-method')) {
        break;
      }

      target = target.parentNode;
    }

    if (target === this || target.disabled || target.className.indexOf('disabled') > -1) {
      return;
    }

    data = {
      method: target.getAttribute('data-method'),
      target: target.getAttribute('data-target'),
      option: target.getAttribute('data-option') || undefined,
      secondOption: target.getAttribute('data-second-option') || undefined
    };

    cropped = cropper.cropped;

    if (data.method) {
      if (typeof data.target !== 'undefined') {
        input = document.querySelector(data.target);

        if (!target.hasAttribute('data-option') && data.target && input) {
          try {
            data.option = JSON.parse(input.value);
          } catch (e) {
            console.log(e.message);
          }
        }
      }

      switch (data.method) {
        case 'rotate':
          if (cropped && options.viewMode > 0) {
            cropper.clear();
          }

          break;

        case 'getCroppedCanvas':
          
          //$("#usar_img").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");

          try {
            data.option = JSON.parse(data.option);
          } catch (e) {
            console.log(e.message);
          }

          if (uploadedImageType === 'image/jpeg') {
            if (!data.option) {
              data.option = {};
            }

            data.option.fillColor = '#fff';
          }

          break;
      }

      result = cropper[data.method](data.option, data.secondOption);

      switch (data.method) {
        case 'rotate':
          if (cropped && options.viewMode > 0) {
            cropper.crop();
          }

          break;

        case 'scaleX':
        case 'scaleY':
          target.setAttribute('data-option', -data.option);
          break;

        case 'getCroppedCanvas':
          if (result) {
            // Bootstrap's Modal
            var responseUpload = $('#responseUpload');
            responseUpload.hide();

            $('#getCroppedCanvasModal').modal().find('.modal-body').html(result);

           // $("#usar_img").prop('disabled',false).html("Usar Imagem");
            // console.log(result, result.toDataURL(uploadedImageType) );
            
            avatar.src = result.toDataURL()

            document.getElementById('confirm').addEventListener('click', function () {
              
              result.toBlob(function (blob) {
                var formData = new FormData();
               
                var idsolicitacao = document.getElementById('upload_idsolicitacao').value;
                var inscricao     = document.getElementById('upload_inscricao').value;
                var tipo_anexo    = document.getElementById('upload_tipo_anexo').value;
                var label_anexo   = document.getElementById('upload_label_anexo').value;

                var responseUpload = $('#responseUpload');
                responseUpload.hide();
                var res = blob.type.split("/");

                formData.append('file', blob, tipo_anexo+'.'+res[1]);

                formData.append('idsolicitacao',  idsolicitacao );
                formData.append('inscricao',      inscricao );
                formData.append('tipo_anexo',     tipo_anexo );
                formData.append('label_anexo',    label_anexo );

                $(this).prop('disabled', true);

                $.ajax(document.location['href']+'/uploadFile', {
                  type: 'POST',
                  method: 'POST',
                  data: formData,
                  processData: false,
                  contentType: false,
                  dataType: 'JSON',

                  xhr: function () {
                    var xhr = new XMLHttpRequest();

                    xhr.upload.onprogress = function (e) {
                      var percent = '0';
                      var percentage = '0%';

                      if (e.lengthComputable) {
                        percent = Math.round((e.loaded / e.total) * 100);
                        percentage = percent + '%';
                        // console.log(percentage);
                      }
                    };

                    return xhr;
                  },
                  
                  beforeSend: function(){
                    $("#confirm").prop('disabled',true).html("<i class='fas fa-spinner fa-spin'></i> Aguarde");
                  },
                  success: function (res) {
                    console.log(res);
                    
                    $("#confirm").prop('disabled', false).html('Confirmo');

                    if(res.type == "success"){
                      $("#confirm").hide();
                      $("#cancel").attr('reload', 'true');
                    }

                    
                    responseUpload.addClass('alert-'+res.type).html(res.message).show();
                    // $alert.show().addClass('alert-success').text('Upload success');

                  },

                  error: function (res) {
                  // avatar.src = initialAvatarURL;
                    console.log('Upload error !!', res);
                  // $alert.show().addClass('alert-warning').text('Upload error');
                  },

                  complete: function () {
                    // console.log('complete');
                    // $progress.hide();
                  },
                });
              });

            });
            
            /*
            if (!download.disabled) {
              download.download = uploadedImageName;
              download.href = result.toDataURL(uploadedImageType);
            }
            */
          }

          break;

        case 'destroy':
          cropper = null;

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
            uploadedImageURL = '';
            image.src = originalImageURL;
          }

          break;
      }

      if (typeof result === 'object' && result !== cropper && input) {
        try {
          input.value = JSON.stringify(result);
        } catch (e) {
          console.log(e.message);
        }
      }
    }
  };

  document.body.onkeydown = function (event) {
    var e = event || window.event;

    if (e.target !== this || !cropper || this.scrollTop > 300) {
      return;
    }
    
    switch (e.keyCode) {
      case 37:
        e.preventDefault();
        cropper.move(-1, 0);
        break;

      case 38:
        e.preventDefault();
        cropper.move(0, -1);
        break;

      case 39:
        e.preventDefault();
        cropper.move(1, 0);
        break;

      case 40:
        e.preventDefault();
        cropper.move(0, 1);
        break;
    }
    
  };




  // Import image
  var inputImage = document.getElementById('inputImage');

  if (URL) {
    inputImage.onchange = function () {
      var files = this.files;
      var file;

      if (cropper && files && files.length) {
        file = files[0];

        if (/^image\/\w+/.test(file.type)) {
          uploadedImageType = file.type;
          uploadedImageName = file.name;

          if (uploadedImageURL) {
            URL.revokeObjectURL(uploadedImageURL);
          }

          image.src = uploadedImageURL = URL.createObjectURL(file);
          cropper.destroy();
          cropper = new Cropper(image, options);
          inputImage.value = null;
        } else {
          window.alert('Please choose an image file.');
        }
      }
    };
  } else {
    inputImage.disabled = true;
    inputImage.parentNode.className += ' disabled';
  }
};
