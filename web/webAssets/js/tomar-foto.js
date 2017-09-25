
var numero_fotos = 4;
var tiempo_entre_fotos = 2000;
var timesButton = 0;
var audio = new Audio(basePath + '/webAssets/audio/camera-shooter.mp3');


function reproducirAudio() {
    if (audio) {
        audio.play();
    }
}

function detenerAudio() {
    if (audio) {
        audio.pause();
    }
}

$(document).on({
    'click': function (e) {

        $(".js-imagen-preview").css('opacity', 0.5);
        $(".js-seleccionar-imagen").css('display', 'none');


        var token = $(this).data('token');
        $(this).css('opacity', 1);
        $("#js-seleccionar-imagen-" + token).show();

    }
}, '.js-imagen-preview');

$(document).on({
    'click': function (e) {

        var canvas = document.getElementById('canvas');
        var dataURL = canvas.toDataURL();
        var token = $("#token").val();
        if (timesButton < 1) {
            swal("Espera", "Debes tomarte una foto", "warning");
            return false;
        }
        var l = Ladda.create(this);
        l.start();

        //Guardar las 4 imagenes que se toman
        var arrayImages = [];
        $('.js-imagen-preview').each(function(index){
            arrayImages[index] = $(this).attr('src')
            //alert(index+"---"+$(this).attr('src'));
        });
        //console.log(arrayImages);

        $.ajax({
            type: "POST",
            url: "guardar-foto?token="+token,
            data: {
                imgBase64: arrayImages
                //imgBase64: dataURL,
            },

        }).done(function (o) {
            timesButton = 0;
            setTimeout(function() {
                
            }, 2000);
            $("#js-contenedor-imagenes").html('');

            swal("Ok", "Imagen guardada", "success");
            swal({
                title: "Imagen guardada",
                text: "Gracias por participar. Se ha enviado un SMS con un link para que puedas descargar tu imagen.",
                type: "success",
                showCancelButton: false,
                closeOnConfirm: false
                },
                function(){
               window.location.href = basePath;
            });

            l.stop();
            console.log('saved');
            // If you want the file to be visible in the browser 
            // - please modify the callback in javascript. All you
            // need is to return the url to the file, you just saved 
            // and than put the image in your browser.
        });

    }
}, '.js-seleccionar-imagen');



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


            if (audio) {
                audio.loop = false;
                audio.onended = function () {
                    var templateImagen = "<img class='js-imagen-preview' id='preview-imagen-" + timesButton 
                    + "' data-token='" + timesButton + "' />"+
                    "<button data-style='zoom-in' style='display:none;' id='js-seleccionar-imagen-" + timesButton + "' "+
                    "class='js-seleccionar-imagen ladda-button btn btn-primary' data-token='" + timesButton + 
                    "'> <span class='ladda-label'>   Seleccionar Imagen</span></button>";

                    $("#js-contenedor-imagenes").append(templateImagen);

                    if (videoPlaying) {
                        var canvas = document.getElementById('canvas');
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        canvas.getContext('2d').drawImage(video, 0, 0);
                        var data = canvas.toDataURL('image/png');
                        document.getElementById('preview-imagen-' + timesButton).setAttribute('src', data);
                        timesButton++;
                    }

                    if (timesButton < numero_fotos) {
                        setTimeout(function () { reproducirAudio() }, tiempo_entre_fotos);
                    }

                };
            }

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

            reproducirAudio();

        }, false);



    } else {
        console.log("KO");
    }
})();
