<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Short link</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
</head>
<body>


<div class="container position-relative">

    <div class="toast" style="position: absolute; top: 0; right: 0; z-index: 99;">
        <div class="toast-header">
            {{--            <img src="..." class="rounded mr-2" alt="...">--}}
            <strong class="mr-auto">Short link</strong>
            {{--            <small>11 mins ago</small>--}}
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body" style="z-index: 99;"></div>
    </div>
    <nav class="navbar navbar-expand-md navbar-light bg-light">
        <a class="navbar-brand" href="/">Short link</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
                aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active d-none">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                @auth
                    <li class="nav-item">
                        <a href="/logout" class="nav-link">({{Auth::user()->name}}) Logout</a>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a href="/auth/google" class="nav-link">
                            <img src="/images/btn_login_google.png">
                        </a>
                    </li>
                @endguest
                <li class="nav-item d-none">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown d-none">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                       aria-haspopup="true"
                       aria-expanded="false">Dropdown</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownId">
                        <a class="dropdown-item" href="#">Action 1</a>
                        <a class="dropdown-item" href="#">Action 2</a>
                    </div>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>


    <h1>Short link</h1>

    @if(Session::has('alert_error'))
        <p class="alert alert-danger">{{ Session::get('alert_error') }}</p>
    @endif
    @if(Session::has('show_login_google'))
        <div>
            <a href="/auth/google"><img src="/images/btn_login_google.png"></a>
        </div>
    @endif

    <!-- Content here -->
    @if(isset($shorturl))
        {{ $shorturl }}
    @endif
    @auth()

        <form method='post' id="form-shortlink">
            {{ csrf_field() }}
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="link" name='name' class="form-control" id="inputEmail44" placeholder="Name">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="link" name='shorturl' class="form-control" id="shorturl"
                           placeholder="Custom URL">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="url" required name='longurl' class="form-control" id="longurl"
                           placeholder="Long URL">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="checkbox" name='is_public' class="" id="is_public"
                           value='1'> <label for='is_public'>Public</label>
                </div>
            </div>
            <button type="submit" class="btn btn-info">Make short link</button>
        </form>
    @endauth

    <table class="table">
        <thead class="thead-default d-none">
        <tr>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach (($keys) as $k=> $key)

            <tr>
                <td>{{ $k }}</td>
                <td>
                    <div><textarea class='form-control'>{{ $key->long }}</textarea></div>
                </td>
                <td>
                    <div><input class='form-control' value='{{config('app.url')}}/d/{{ $key->short }}'> <a
                            href="{{config('app.url')}}/d/{{ $key->short }}" class="btn btn-primary" target="_blank">Go</a>
                    </div>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>

</div>
<!-- Modal -->
<div class="modal fade" id="alert-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Incorrect url format
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"
        integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF"
        crossorigin="anonymous"></script>
<script>
    var can_search = true;
    var validate_form = [];
    var config = {
        time_wait_to_search: 200
    }
    $(".toast").toast({"delay": 1000});
    $('.toast').on('hidden.bs.toast', function () {
        $(".toast .toast-body").text('');
    })

    $("#shorturl").keyup(() => {
        console.log(can_search);
        if (can_search === true) {
            can_search = false;
            setTimeout(() => {
                let mmm = $("#shorturl").val();
                $.get('/api/check?l=' + mmm, (data) => {
                    if (data.error_code === 0) {
                        $("#shorturl").addClass('text-success');
                        $("#shorturl").removeClass('text-danger');
                        validate_form = [];
                    } else {
                        $("#shorturl").focus();
                        validate_form.push({'message': 'Short link douplicate'});
                        $(".toast .toast-body").text('Short link duplicate in db');
                        $(".toast").toast('show');
                        $("#shorturl").removeClass('text-success');
                        $("#shorturl").addClass('text-danger');
                    }
                });
                can_search = true;
            }, config.time_wait_to_search);
        }
    });
    var is_wrong_format_long = false;
    var is_wrong_format_short = false;
    $("#form-shortlink").submit(function (e) {
        is_wrong_format_long = (!$("#longurl").first().val().match(/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)/));
        is_wrong_format_short = (validate_form.length != 0);
        if (is_wrong_format_long || is_wrong_format_short) {

            $("#longurl").removeClass('text-success');
            $("#longurl").addClass('text-danger');

            $(".toast .toast-body").text('Wrong format form');
            $(".toast").toast('show');
            return false;
        }else{
            $("#longurl").addClass('text-success');
            $("#longurl").removeClass('text-danger');
        }
    })
</script>
</body>
</html>
