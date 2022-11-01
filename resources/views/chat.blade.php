@extends('layouts.app1')
@section('HeaderContent')
    <link rel="stylesheet/less" type="text/css" href="/css/chat.less"/>
    <script src="/js/less.js" type="text/javascript"></script>

    <script id="script">


        var s = document.createElement("script")
        s.src = "https://notix.io/ent/current/enot.min.js"
        s.onload = function (sdk) {
            sdk.startInstall({
                appId: "{{config('app.notificationAppId')}}",
                loadSettings: true,
                disableConsoleDebug: true
            })
        }
        document.head.append(s)
    </script>
@endsection
@section('BodyContent')

    <div class="text-center">

        <h2>Chat</h2>
        <input type="radio" class="userid" name="userid" value="1" checked id="userid1"> <label for="userid1">Em</label>
        <input type="radio" class="userid" name="userid" value="2" id="userid2"> <label for="userid2">Anh</label>

        <div id="wrapMessage">
            @foreach ($ms as $m)
                <div class="bubbleWrapper" data-id="{{$m->id}}">
                    <div class="inlineContainer {{$m->userid ==1?'own':''}}">
                        <img class="inlineIcon d-none"
                             src="">
                        <div class="msgcontent {{$m->userid ==2?'otherBubble other':'ownBubble own'}}"
                             data-id="{{$m->id}}">
                            {{$m->message}}
                        </div>
                    </div>
                    <span class="own d-none">08:55</span>
                </div>
            @endforeach
        </div>

        <div class="">
            <div class="">
                <div class="float-right">
                    <input type="file" class="d-none" id="inputFile" accept="image/*">
                    <button class="btn btn-primary" onclick="MessageService.openEmoji()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-emoji-smile" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                            <path
                                d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"></path>
                        </svg>
                    </button>
                    <button class="btn btn-primary" onclick="MessageService.openRecord()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-mic" viewBox="0 0 16 16">
                            <path
                                d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"></path>
                            <path
                                d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0v5zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3z"></path>
                        </svg>
                    </button>
                    <button class="btn btn-primary" onclick="MessageService.upFile()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-file-earmark-image" viewBox="0 0 16 16">
                            <path d="M6.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"></path>
                            <path
                                d="M14 14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5V14zM4 1a1 1 0 0 0-1 1v10l2.224-2.224a.5.5 0 0 1 .61-.075L8 11l2.157-3.02a.5.5 0 0 1 .76-.063L13 10V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4z"></path>
                        </svg>
                    </button>
                    <button class="btn btn-primary" onclick="MessageService.sendMessage()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-send-fill" viewBox="0 0 16 16">
                            <path
                                d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"></path>
                        </svg>
                    </button>
                </div>
                <div class="wrap-text-input">
                    <input type="text" name="input-text" class="form-control input-text" placeholder="Chat message">
                </div>
                <div class="clearfix"></div>

            </div>
        </div>

    </div>
    <div class="text-center">
        <a class="btnlogout btn btn-secondary" href="/logout">Logout</a></div>
    <div class="text-center"></div>
    <div class="modal" tabindex="-1" role="dialog" id="mi-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-none">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger thuhoi">Thu hồi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="mi-record-voice">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="d-none"><span class="statusR">Off</span></div>
                    <button class="btn" onclick="AppService.startRecord()" id="button-record">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-mic" viewBox="0 0 16 16">
                            <path
                                d="M3.5 6.5A.5.5 0 0 1 4 7v1a4 4 0 0 0 8 0V7a.5.5 0 0 1 1 0v1a5 5 0 0 1-4.5 4.975V15h3a.5.5 0 0 1 0 1h-7a.5.5 0 0 1 0-1h3v-2.025A5 5 0 0 1 3 8V7a.5.5 0 0 1 .5-.5z"></path>
                            <path
                                d="M10 8a2 2 0 1 1-4 0V3a2 2 0 1 1 4 0v5zM8 0a3 3 0 0 0-3 3v5a3 3 0 0 0 6 0V3a3 3 0 0 0-3-3z"></path>
                        </svg>
                    </button>
                    <div>
                        <audio style="width:100%" id="wavSource" type="audio/wav" controls
                               style="display:none;"></audio>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" onclick="VoiceService.uploadAudio();" id="button-sent-voice"
                            style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-send-fill" viewBox="0 0 16 16">
                            <path
                                d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083l6-15Zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471-.47 1.178Z"></path>
                        </svg>
                        Sent Voice
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="mi-emoji">
        <div class="modal-dialog  modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Emoji</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div class="wrap-emoji">
                        <div id="emoji">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="loadingScreen" style="display:none;"></div>
@endsection
@section('FooterContent')
    <script src="/js/objectEmoji.js" type="text/javascript"></script>
    <script>

    </script>
    <script>


        var config = {
            time_count: 10000,
            pusher_key: '{{config('broadcasting.connections.pusher.key')}}',
            pusher_cluster: '{{config('broadcasting.connections.pusher.options.cluster')}}',
        }
    </script>
    <script src="/js/countdownloadpage.js"></script>
    <script src="/js/pusher.js"></script>
    <script src="/js/chat.js"></script>
@endsection
