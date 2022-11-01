@extends('layouts.app1')
@section('BodyContent')

<style>
.clock {
    color: #959595;
    font-size: 37px;
    font-family: arial;
    letter-spacing: 1px;
}
</style>



<form method="post" action="{{$action??'/password'}}">
    <input type="password" class='form-control' name='password' id="password">
</form>
@endsection
@section('FooterContent')
<script type="text/javascript">
$("#password").focus();
</script>
@endsection
