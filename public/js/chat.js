var VoiceService = {
    statusRecord: false,
    chunks: [],
    mediaRecorder: null,
    start: () => {
        navigator.mediaDevices.getUserMedia({
            audio: true,
        })
            .then((stream) => {
                VoiceService.mediaRecorder = new MediaRecorder(stream);
                VoiceService.mediaRecorder.start();
                VoiceService.mediaRecorder.ondataavailable = (e) => {
                    VoiceService.chunks.push(e.data);
                };
                VoiceService.mediaRecorder.onstop = () => {
                    let stream = VoiceService.mediaRecorder.stream;
                    let tracks = stream.getTracks();

                    tracks.forEach((track) => {
                        track.stop();
                    });
                    document.getElementById("wavSource").style.display = 'block';
                    let audioBlob = new Blob(VoiceService.chunks, {type: 'audio/mpeg3'});
                    let blobURL = window.URL.createObjectURL(audioBlob);
                    document.getElementById("wavSource").src = blobURL;
                    document.getElementById("wavSource").play();
                    //reset to default
                    VoiceService.mediaRecorder = null;
                };
            })
            .catch((err) => {
                alert(`The following error occurred: ${err}`);
            });
    },
    uploadAudio: function () {
        let audioBlob = new Blob(VoiceService.chunks, {type: 'audio/wav'});
        VoiceService.uploadVoice(audioBlob);
        document.getElementById("wavSource").style.display = 'none';
        VoiceService.chunks = [];
    },
    uploadVoice: function (data) {
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
            $('.input-text').trigger('addTagAudio', data)
            MessageService.sendMessage();
            $('#mi-record-voice').modal('hide');
        });
    }
}
var AppService = {

    showLoadingScreen: () => {
        $('#loadingScreen').show();
    },
    hideLoadingScreen: () => {
        $('#loadingScreen').hide();
    },
    setCurrentUserId: () => {
        let crr_userid = localStorage.getItem('userid');
        $("#userid" + crr_userid).prop('checked', 'checked');
        $(".userid").change((e) => {
            localStorage.setItem('userid', $(e.target).attr('value'));
        })
    },
    startRecord: () => {
        if (VoiceService.statusRecord === false) {
            VoiceService.chunks = [];
            VoiceService.start();
            $("#button-record").css({"background": 'red'});
            VoiceService.statusRecord = true;
            $(".statusR").text('true');
            $("#button-sent-voice").hide();
        } else {
            VoiceService.statusRecord = false;
            $(".statusR").text('false');
            VoiceService.mediaRecorder.stop();
            $("#button-sent-voice").show();
            $("#button-record").css({"background": 'none'});
        }
    },
    pushNotification: (message) => {
        return false;
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
}
var MessageService = {
    current_target_id: 0,
    openEmoji: () => {
        $("#mi-emoji").modal('show');
    },
    addEvents: (selector) => {
        selector.on('render', function (e) {
            let m = $(this).find('.msgcontent');
            let text = m.text().trim();
            let result = (text.match(/\[img id:"(.+)"\]/));
            if (result != null) {
                console.log(result[1]);
                $.get('/api/upload/' + result[1], (data) => {
                    let url = data.fullurl;
                    m.html("<div class='text-center img-preview'><img src='" + url + "'></div>");
                    setTimeout(() => {
                        MessageService.gotoBottom();
                    }, 400);
                })
            }

            result = (text.match(/\[audio id:"(.+)"\]/));
            if (result != null) {
                console.log(result[1]);
                $.get('/api/upload/' + result[1], (data) => {
                    let url = data.fullurl;
                    // m.html("<div class='text-center img-preview'><img src='" + url + "'></div>");
                    //m.html("<button src='" + url + "' >play</button> <audio style='width:200px'  type='audio/wav' controls src='" + url + "' ></audio>");
                    m.html("<button class='playVoice' src='" + url + "' >play</button><button class='stopVoice' src='" + url + "' >stop</button>");
                    setTimeout(() => {
                        MessageService.gotoBottom();
                    }, 200);
                })
            }


            result = (text.match(/\[emoji id:"(.+)"\]/));
            if (result != null) {
                let id_message = $(this).attr('data-id');
                k = 'mmmdd-'+id_message;
                mmm[k] = new Emoji(listEmoji[result[1]]);
                $(this).find('.msgcontent').html($("<div class='div"+k+"'>"));
                mmm[k].id = k;
                mmm[k].selector = $(".div" + k);
                mmm[k].runAnimations();
                setTimeout(() => {
                    MessageService.gotoBottom();
                }, 200);

            }
        })
    },
    openRecord: () => {
        $('#mi-record-voice').modal('show');
    },
    addMessage: (m) => {
        let mss = $(".bubbleWrapper").first().clone();
        $(mss).find('.msgcontent').html(m.data.message);
        $(mss).find('.msgcontent').attr('data-id', m.data.id);
        $(mss).attr('data-id', m.data.id);
        MessageService.addEvents($(mss));
        if (m.data.userid == 2) {
            $(mss).find('.msgcontent').addClass('otherBubble other');
            $(mss).find('.msgcontent').removeClass('ownBubble own');
            $(mss).find('.inlineContainer').removeClass('own');
        } else {
            $(mss).find('.inlineContainer').addClass('own');
        }
        $(mss).find('.msgcontent').html(m.message);
        $('#wrapMessage').append(mss);
        $(mss).trigger('render');
        MessageService.gotoBottom();
    },
    gotoBottom: () => {
        console.log('gotoBottom');
        let out = document.getElementById("wrapMessage");
        out.scrollTop = out.scrollHeight - out.clientHeight + 100;
    },
    sendMessage: () => {
        if ($(".input-text").val().trim() === '') {
            alert('Please enter text');
            return;
        }
        let userid = $(".userid:checked").val().trim();
        let textInput = $(".input-text").val().trim();
        $(".input-text").val('');
        AppService.showLoadingScreen();
        $.post('/api/message', {"message": textInput, "userid": userid}, () => {
            AppService.hideLoadingScreen();
        });
    },
    thuhoi() {
        console.log('thuhoi');
        if (this.current_target_id === undefined) return;
        AppService.showLoadingScreen();
        $.ajax({
            url: '/api/message/' + this.current_target_id,
            type: 'DELETE',
            contentType: 'application/json',  // <---add this
            dataType: 'text',                // <---update this
            success: function (result) {
                AppService.hideLoadingScreen();
                $("#mi-modal").modal('hide');
            },
            error: function (result) {
                AppService.hideLoadingScreen();
                $("#mi-modal").modal('hide');
            }
        });
    },
    upFile() {
        $("#inputFile").click();
    }
}

// set radio button
AppService.setCurrentUserId();

// Sau 2 giây thì nhảy xuống dưới
setTimeout(() => {
    MessageService.gotoBottom();
}, 500);

function uploadFile(callback) {
    var file_data = $('#inputFile').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    AppService.showLoadingScreen();
    $.ajax({
        url: '/api/upload', // <-- point to server-side PHP script
        dataType: 'text',  // <-- what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: (php_script_response) => {
            AppService.hideLoadingScreen();
            data = JSON.parse(php_script_response);
            $('.input-text').trigger('addTagImage', {id: data.id});
            callback();
        },
        error: () => {
            AppService.hideLoadingScreen();
        }
    });
}

$("#wrapMessage").on('addMessage', (e, m) => {
    let mss = $(".bubbleWrapper").first().clone();
    $(mss).find('.msgcontent').html(m.data.message);
    $(mss).find('.msgcontent').attr('data-id', m.data.id);
    $(mss).attr('data-id', m.data.id);
    MessageService.addEvents($(mss));
    if (m.data.userid == 2) {
        $(mss).find('.msgcontent').addClass('otherBubble other');
        $(mss).find('.msgcontent').removeClass('ownBubble own');
        $(mss).find('.inlineContainer').removeClass('own');
    } else {
        $(mss).find('.inlineContainer').addClass('own');
    }
    $(mss).find('.msgcontent').html(m.data.message);
    $('#wrapMessage').append(mss);
    $(mss).trigger('render');
    MessageService.gotoBottom();
});

$("#wrapMessage").on('deleteMessage', (e, id_delete) => {
    $(".bubbleWrapper").find('[data-id=' + id_delete + ']').hide();
});

var pusher = new Pusher(config.pusher_key, {
    cluster: config.pusher_cluster,
    encrypted: true
});
// Subscribe to the channel we specified in our Laravel Event
var channel = pusher.subscribe('sent-message');
// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\SentMessage', (data) => {
    AppService.pushNotification(data.data.message);
    $("#wrapMessage").trigger('addMessage', data);
});
channel.bind('App\\Events\\DeleteMessage', (data) => {
    $("#wrapMessage").trigger('deleteMessage', data.data.id);
});
$(document).on('visibilitychange', (e)=>{
    console.log(document.hidden);
    if (document.hidden==false) {
        console.log('v')
    } else {
        console.log('u')
        window.location.href = '/lock';
    }
} );

var current_target = null;
var current_target_id = null;
$(document).on('click', '.msgcontent', (event) => {
    current_target = $(event.target).closest('.msgcontent');
    current_target_id = $(current_target).attr('data-id');
    MessageService.current_target_id = current_target_id;
    $("#mi-modal .modal-body").html($(current_target).html());
    $("#mi-modal .modal-body").removeClass("d-none");
    $("#mi-modal").modal('show');
});

MessageService.addEvents($(".bubbleWrapper"));
$(".bubbleWrapper").trigger('render');

$(".input-text").keyup((e) => {
    i = 1;
    if (e.which === 13) {
        MessageService.sendMessage();
    }
})
$(".card-block").click(() => {
    timeoutPage = 0;
})
$(".thuhoi").click(() => {
    MessageService.thuhoi();
})
$("#inputFile").change(() => {
    uploadFile(() => {
        MessageService.sendMessage();
    });
})
$('.input-text').on('addTagImage', function (e, data) {
    $(this).val('[img id:"' + data.id + '"]');
});
$('.input-text').on('addTagAudio', function (e, data) {
    $(this).val('[audio id:"' + data.id + '"]');
});
$('.input-text').on('addTagEmoji', function (e, data) {
    $(this).val('[emoji id:"' + data.id + '"]');
});
$(document).on('click', ".playVoice", () => {
})
eventBus.on('addEmoji', (e, d) => {
    $('.input-text').trigger('addTagEmoji', {id: d.id});
    MessageService.sendMessage();
    $('#mi-emoji').modal('hide');
});
