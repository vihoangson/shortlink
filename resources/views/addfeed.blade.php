@extends('layouts.app2')
@section('BodyContent')
    <div class="text-center">
        <div><img src="" id="img" class="d-none"></div>
        <input type="file" id="sortpicture" class="d-none" accept="image/png, image/gif, image/jpeg">
        <button class="btn btn-info" id="upload">UPLOAD</button>
        <div>
            <input type="hidden" id="upload_id">
            <input type="text" id="textfeed" class="form-control" placeholder="How is your feeling  ?">
        </div>
        <div>
            <button class="btn btn-primary" onclick="submitForm()">SAVE</button>
        </div>
    </div>

    <div class="text-center feeds"></div>
    <div class="card" id="cardTemplate">
        <div class="card-body">
        </div>
    </div>
@endsection
@section('FooterContent')
    <script>
        loadFeed();

        function loadFeed() {
            $('.feeds').html('');
            $.get('/api/feed', (data) => {
                $.each(data, (k, d) => {
                    let m = $('#cardTemplate').clone();
                    m.attr('id', '');
                    m.find('.card-body').html(d.content);
                    //console.log( (d.url_img));
                    // console.log(d.url_img!=null);
                    if ((d.url_img) != null) {
                        m.find('.card-body').append('<img class="img-thumbnail" src="/storage/files/' + d.url_img.filename + '/' + d.url_img.filename + '">');
                    }
                    $('.feeds').prepend(m);
                })
            })
        }

        function submitForm() {
            var textfeed = $('#textfeed').val();
            var form_data = new FormData();
            form_data.append('content', textfeed);
            form_data.append('upload_id', $("#upload_id").val());
            $.ajax({
                url: '/api/feed', // <-- point to server-side PHP script
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: (php_script_response) => {
                    php_script_response = JSON.parse(php_script_response);
                    $('#textfeed').val('');
                    $("#upload_id").val(0);
                    $("#img").addClass('d-none');
                    loadFeed();
                }
            });
        }

        $('#upload').on('click', () => {
            $("#sortpicture").click();
        });
        $("#sortpicture").change(uploadFile);

        function uploadFile() {
            var file_data = $('#sortpicture').prop('files')[0];
            var textfeed = $('#textfeed').val();
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                url: '/api/upload', // <-- point to server-side PHP script
                dataType: 'text',  // <-- what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: (php_script_response) => {
                    php_script_response = JSON.parse(php_script_response);
                    $("#img").attr('src', '/storage/files/' + php_script_response.filename + '/' + php_script_response.filename);
                    $("#upload_id").val(php_script_response.id)
                    $("#img").removeClass('d-none');

                }
            });
        }
    </script>
@endsection
