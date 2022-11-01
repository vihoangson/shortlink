<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <style type="text/css">
        #record {
            background-color: red; /* Green */
            border-width: medium;
            border-color: black;
            color: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            max-width: 50%;
            max-height: 15%;
            border-radius: 50%;
            left: 100px;
            right: 100px;
            position: relative;
        }

        #stopRecord {
            background-color: green; /* Green */
            border-width: medium;
            border-color: black;
            color: white;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            max-width: 50%;
            max-height: 15%;
            border-radius: 50%;
            left: 100px;
            right: 100px;
            position: relative;
        }

        h2 {
            left: 100px;
            position: relative;
        }

        #recordedAudio {
            left: 100px;
            right: 100px;
            position: relative;
        }
    </style>
</head>

<body>
<button onclick="notifyMe('sssss')">Notify me!</button>
<button onclick='startStreamedAudio()'>1</button>
<button onclick='stopStreamedAudio()'>2</button>
<button onclick='uploadAudio()'>3</button>

<div><audio id="wavSource" type="audio/wav" controls style="display:none;"></audio></div>

<script
    src="https://code.jquery.com/jquery-2.2.4.min.js"
    integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
    crossorigin="anonymous"></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script>

    function notifyMe(message) {
        if (!("Notification" in window)) {
            // Check if the browser supports notifications
            alert("This browser does not support desktop notification");
        } else if (Notification.permission === "granted") {
            // Check whether notification permissions have already been granted;
            // if so, create a notification
            const notification = new Notification(message);
            // …
        } else if (Notification.permission !== "denied") {
            // We need to ask the user for permission
            Notification.requestPermission().then((permission) => {
                if (permission === "granted") {
                    const notification = new Notification(message);
                }
            });
        }
    }
</script>
<script>

    let chunks = []; //will be used later to record audio
    let mediaRecorder = null; //will be used later to record audio
    let audioBlob = null;
    document.getElementById("wavSource").style.display = 'none';
    function stopStreamedAudio() {
        mediaRecorder.stop();
    }

    function startStreamedAudio() {
        navigator.mediaDevices.getUserMedia({
            audio: true,
        })
            .then((stream) => {
                mediaRecorder = new MediaRecorder(stream);
                mediaRecorder.start();
                mediaRecorder.ondataavailable = (e) => {
                    chunks.push(e.data);
                };
                mediaRecorder.onstop = () => {
                    let stream = mediaRecorder.stream;
                    let tracks = stream.getTracks();

                    tracks.forEach((track) => {
                        track.stop();
                    });
                    document.getElementById("wavSource").style.display = 'block';
                    let audioBlob = new Blob(chunks, {type: 'audio/mpeg3'});
                    let blobURL = window.URL.createObjectURL(audioBlob);
                    document.getElementById("wavSource").src = blobURL;
                    document.getElementById("wavSource").play();
                    //reset to default
                    mediaRecorder = null;
                    //chunks = [];

                };
            })
            .catch((err) => {
                alert(`The following error occurred: ${err}`);
            });
    }
    function uploadAudio(){
        let audioBlob = new Blob(chunks, {type: 'audio/wav'});
        sendData(audioBlob);
        document.getElementById("wavSource").style.display = 'none';
        chunks = [];
    }

    function sendData(data) {
        var fd = new FormData();
        fd.append('filename', 'test.mp3');
        fd.append('file', data);
        $.ajax({
            type: 'POST',
            url: '/api/upload',
            data: fd,
            processData: false,
            contentType: false
        }).done(function (data) {
            console.log(data);
        });
    }
</script>
</body>

</html>
