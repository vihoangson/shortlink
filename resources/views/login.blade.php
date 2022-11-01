@extends('layouts.app1')
@section('HeaderContent')
@endsection
@section('BodyContent')
<form action="" method="post">
    @csrf
    <input type="password" class="form-control" name="password" id="password">
</form>

@endsection
@section('FooterContent')
    <script type="text/javascript">
        $("#password").focus();
    </script>
@endsection
