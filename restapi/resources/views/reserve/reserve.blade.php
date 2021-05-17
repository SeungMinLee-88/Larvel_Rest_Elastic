@extends('layouts.master')
@section('content')
{{$token}}
<div class="form-group">

</div>
{{--http://localhost:8000/api/v1/member/reservelist?hallid=1&reservedate=2021-03&include=reservetime,user--}}
@stop
@section('script')
    <script>
$(document).ready(function(){
$.ajax({
    url: "http://localhost:8000/api/v1/member/reservelist?hallid=1&reservedate=2021-03&include=reservetime,user",
    type: "GET",
    dataType : "json",
    /*data:{ajaxcall : "ajaxcall"},*/
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': `Bearer {{$token}}`
    },
    success : function(data) {
        console.log(data);

    },
    error : function(data){
        alert(data);
    }


})
});
    </script>
@stop
