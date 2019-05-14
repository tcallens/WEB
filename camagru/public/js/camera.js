(function() {
    //fonction anonyme qui s'appel elle meme pour ne pas avoir de variable global

    var width = 640;    // We will scale the photo width to this
    var height = 480;     // This will be computed based on the input stream

    var streaming = false;

    //webcam elements
    var webcam = null;
    var takePhotoButton = null;
    var photoCanvas = null;
    var photoContext = null;


    //filter elements
    var webcamFilter = null;
    var radioButton1 = null;
    var radioButton2 = null;
    var radioButton3 = null;
    var radioButton4 = null;
    var radioButton5 = null;

    var httpRequest = null;
    var postPhotoButton = null;
    var isUpload = 0;
    var url = null;
    const upLoadForm = document.getElementById('f_upload');
    const inputFile = document.getElementById('inputfile');

    function startup() {

        //on recupere les elementes selon leur ID
        webcam = document.getElementById('webcam');
        takePhotoButton = document.getElementById('takePhotoButton');
        photoCanvas = document.getElementById('photo_canvas');
        photoContext = photoCanvas.getContext('2d');


        webcamFilter = document.getElementById('webcamFilter');
        webcamFilter.flag = 0;
        // filterCanvas = document.getElementById('filter_canvas');
        // filterContext = filterCanvas.getContext('2d');
        radioButton1 = document.getElementById('rick_and_morty_portal');
        radioButton2 = document.getElementById('rickornichon');
        radioButton3 = document.getElementById('jerry_portal');
        radioButton4 = document.getElementById('rick_morty_title');
        radioButton5 = document.getElementById('f_none');

        postPhotoButton = document.getElementById('postPhotoButton');
        url = "http://localhost:8080/camagru_ok/public/photoQuery.php";

        //on utilise getUserMedia pour recupérer la video sans l'audio

        navigator.getMedia = (
            navigator.getUserMedia ||
            navigator.webkitGetUserMedia
        );

        if(navigator.getMedia)
        {
            navigator.mediaDevices.getUserMedia({video: true, audio: false})
                .then(function (stream) {
                    //on met la reponse de la callback dans l'element video
                    webcam.srcObject = stream;
                    webcam.play();
                    postPhotoButton.disabled = true;
                    webcam.style.display = "inline-block";
                })
                .catch(function (err) {
                    console.log("An error occurred! " + err);
                });

            //on ajuste la taille avant la fin de lancement de la webcam
            webcam.addEventListener('canplay', function(){
                if (!streaming) {
                    // height = 480;

                    console.log(height);
                    webcam.setAttribute('width', width);
                    webcam.setAttribute('height', height);
                    photoCanvas.setAttribute('width', width);
                    photoCanvas.setAttribute('height', height);
                    webcamFilter.setAttribute('width', width);
                    webcamFilter.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            //Button pour prendre la photo
            takePhotoButton.addEventListener('click', function(ev){
                takephoto();
                ev.preventDefault();
            }, false);
        }
        else
        {
            takePhotoButton.disabled = true;
            // height = 480;
            webcam.setAttribute('width', width + "px");
            webcam.setAttribute('height', height + "px");
            photoCanvas.setAttribute('width', width + "px");
            photoCanvas.setAttribute('height', height + "px");
        }

        upLoadForm.addEventListener('submit', e => {
            e.preventDefault();


            stopStreamedVideo(webcam);
            clearphoto();
            const files = document.querySelector('[type=file]').files;
            var img = document.getElementById('upload_image');
            var pError = document.getElementById('error');
            var extensions = ['jpg', 'jpeg', 'png', 'gif'];
            var error = "";

            console.log("type = ", files[0].type);
            console.log("name = ", files[0].name);
            pError.innerText = "";
            for (var i = 0; i < files.length; i++)
            {
                if (i > 1)
                {
                    error = 'Number of Files exceeds limit: 1 max';
                    break;
                }
                let file_ext = files[i].type.split('/');
                if (extensions.indexOf(file_ext[1]) === -1)
                {
                    error = 'Extension not allowed: ' + files[i].name + " est un " + files[i].type;
                }
            }
            if (error.length)
            {
                console.log(error);
                pError.innerText = error;
                pError.style.display = "inline-block";
            }
            else
            {
                img.src = URL.createObjectURL(files[0]);
                img.height = height;
                img.width = width;
                img.onload = function () {
                    URL.revokeObjectURL(files[0]);
                };
                const style = img.style;
             	style.display = "inline";
             	webcam.style.display = "none";
                isUpload = 1;
            }
            postPhotoButton.disabled = false;
        });

        postPhotoButton.addEventListener('click', function(){
            savephoto();
            location.assign("http://localhost:8080/camagru_ok/public/index.php");
        }, false);

        radioButton1.addEventListener('click', function(){
            add_filter(1);
        }, false);
        radioButton2.addEventListener('click', function(){
            add_filter(2);
        }, false);
        radioButton3.addEventListener('click', function(){
            add_filter(3);
        }, false);
        radioButton4.addEventListener('click', function(){
            add_filter(4);
        }, false);
        radioButton5.addEventListener('click', function(){
            add_filter(5);
        }, false);

        clearphoto();
    }

    function clearphoto() {
        var context = photoCanvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, photoCanvas.width, photoCanvas.height);
    }

    function atoi(str)
    {
        //convertit la string "130px" en "130"
        var array = str.split("p");
        return parseInt(array[0]);

    }
    function takephoto() {
        //on dessine l'image dans la canvas
        if (takePhotoButton.value !== "Retry" && width && height)
        {
            webcam.pause();
            takePhotoButton.value = "Retry";
            postPhotoButton.disabled = false;
        } else
        {
            clearphoto();
            webcam.play();
            takePhotoButton.value = "Take photo";
            postPhotoButton.disabled = true;
        }
    }
    function savephoto() {
        photoCanvas.width = width;
        photoCanvas.height = height;
        var imgToDraw = (isUpload) ? document.getElementById('upload_image') : webcam;
        photoContext.drawImage(imgToDraw, 0, 0, width, height);
        var img = photoCanvas.toDataURL('image/png');
        httpRequest = new XMLHttpRequest();
        httpRequest.open('POST', url , false);
        httpRequest.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        var toSend = "img=" + img;
        toSend += (webcamFilter.flag) ? "&srcFilters=" +  webcamFilter.src + "&h=" + webcamFilter.height + "&w=" + webcamFilter.width +
            "&x=" + atoi(webcamFilter.style.left)+ "&y=" + atoi(webcamFilter.style.top) : "";
        console.log(toSend);
        httpRequest.send(toSend);
        postPhotoButton.disabled = true;
    }

    function add_filter(btn)
    {
        webcamFilter.style.position = "absolute";
        webcamFilter.style.display = "inline";
        webcamFilter.flag = 1;
        switch (btn) {
            case 1:
                webcamFilter.setAttribute('src', "img/filters/rick_and_morty_portal.png");
                webcamFilter.style.top = "50px";
                webcamFilter.style.left = "50px";
                webcamFilter.width = width;
                webcamFilter.height = height;
                break;
            case 2:
                webcamFilter.setAttribute('src', "img/filters/rickornichon.png");
                webcamFilter.style.top = "120px";
                webcamFilter.style.left = "150px";
                webcamFilter.width = width / 2;
                webcamFilter.height = height / 2;
                break;
            case 3:
                webcamFilter.setAttribute('src', "img/filters/jerry_portal.png");
                webcamFilter.style.top = "0";
                webcamFilter.style.left = "-80px";
                webcamFilter.width = width;
                webcamFilter.height = height;
                break;
            case 4:
                webcamFilter.setAttribute('src', "img/filters/rick_morty_title.png");
                webcamFilter.style.top = "0";
                webcamFilter.style.left = "0";
                webcamFilter.width = width;
                webcamFilter.height = height;
                break;
            case 5:
                webcamFilter.setAttribute('src', "");
                webcamFilter.style.display = "none";
                webcamFilter.style.top = "0";
                webcamFilter.style.left = "0";
                webcamFilter.width = 0;
                webcamFilter.height = 0;
                break;
            default:
                break;
        }
    }

    inputFile.onchange = function() {
        takePhotoButton.disabled = true;
    };

    function stopStreamedVideo(webcam) {
        let stream = webcam.srcObject;
        if (stream)
        {
            let tracks = stream.getTracks();
            tracks.forEach(function(track) {
                track.stop();
            });
            webcam.srcObject = null;
        }

    }
    //des que les donnes pour demarrer la webcam (load), on lance la fonction startup, false c'est pour empecher la propagation
    window.addEventListener('load', startup, false);
})();
