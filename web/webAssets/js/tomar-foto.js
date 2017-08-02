
function agregarPreviewImage(element, jqelement) {
    var file = element.files[0];

    if (!file) {

        return false;
    }

    var imagefile = file.type;

    var filename = jqelement.val();

    if (filename.substring(3, 11) == 'fakepath') {
        filename = filename.substring(12);
    }// remove c:\fake at beginning from localhost chrome
    // var url = base+'usrUsuarios/guardarFotosCompetencia';

    var match = ["image/jpeg", "image/jpg", 'image/png'];

    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {

        swal("Espera", "Archivo no aceptado por el sistema", "warning");

        return false;
    }

    if (element.files && element.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var token = jqelement.data('token');
            $('#photo2').attr('src', e.target.result);

            //$('#modal-sustain-art-' + token+' .sustain-art-cont-images-dialog-img').css(
            //        'background-image', 'url(' + e.target.result + ')');


        }

        reader.readAsDataURL(element.files[0]);
    }
}
var timesButton = 0;
$(document).ready(function () {

    $("#input-subir-imagen").on("change", function () {
        agregarPreviewImage(this, $(this));
    });

    $("#btn-guardar").on("click", function () {
        var canvas = document.getElementById('canvas');
        var dataURL = canvas.toDataURL();
       if (timesButton < 1) {
            swal("Espera", "Debes tomarte una foto", "warning");
            return false;
        }
        var l = Ladda.create(this);
        l.start();

        $.ajax({
            type: "POST",
            url: "guardar-foto",
            data: {
                imgBase64: dataURL,
            },

        }).done(function (o) {
            timesButton = 0;
           
            $("#photo").attr('src', '');
            swal("Ok", "Imagen guardada", "success");
           
            l.stop();
            console.log('saved');
            // If you want the file to be visible in the browser 
            // - please modify the callback in javascript. All you
            // need is to return the url to the file, you just saved 
            // and than put the image in your browser.
        });
    });
});


; (function () {
    function userMedia() {
        return navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia || null;

    }


    // Now we can use it
    if (userMedia()) {
        var videoPlaying = false;
        var constraints = {
            video: true,
            audio: false
        };
        var video = document.getElementById('v');

        var media = navigator.getUserMedia(constraints, function (stream) {

            // URL Object is different in WebKit
            var url = window.URL || window.webkitURL;

            // create the url and set the source of the video element
            video.src = url ? url.createObjectURL(stream) : stream;

            // Start the video
            video.play();
            videoPlaying = true;
        }, function (error) {
            console.log("ERROR");
            console.log(error);
        });


        // Listen for user click on the "take a photo" button
        document.getElementById('take').addEventListener('click', function () {


            if (videoPlaying) {
                var canvas = document.getElementById('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0);
                var data = canvas.toDataURL('image/webp');
                document.getElementById('photo').setAttribute('src', data);
                timesButton++;
            }
        }, false);



    } else {
        console.log("KO");
    }
})();
