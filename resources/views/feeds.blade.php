@extends('layouts.app2')
@section('BodyContent')
    <div class="text-center">
        <div class="card" id="cardTemplate">
            <div class="card-body">

            </div>
        </div>
    </div>
@endsection
@section('FooterContent')
    <script>
        loadFeed();

        function loadFeed() {
            $.get('/api/feed', (data) => {
                $.each(data, (k, d) => {
                    let m = $('#cardTemplate').clone();
                    m.attr('id', '');
                    m.find('.card-body').html(d.content);
                    //console.log( (d.url_img));
                    // console.log(d.url_img!=null);
                    if ((d.url_img) != null) {
                        m.find('.card-body').append('<img src="/storage/files/' + d.url_img.filename + '/' + d.url_img.filename + '">');
                    }
                    $('.text-center').append(m);
                })
            })
        }
    </script>
@endsection
