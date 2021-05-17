@extends('layouts.master')
@section('content')
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

</head>
<body>
<div id="app">


    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <form id="loginform" action="{{ route('sessionstore') }}" method="POST" role="form" class="form-auth">
                        <div class="card-body">

                                <input type="text" id="token" name="token" value="">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control " name="email" value="" required autocomplete="email" autofocus>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control " name="password" required autocomplete="current-password">

                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="button" class="btn btn-primary">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="http://localhost:8900/password/reset">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            <span class="form-error"></span>

                        </div>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
@stop
@section('script')
<script>
    $(".btn-primary").on("click", function(e) {
        alert($("#email").val());
        alert($("#password").val());
    $.ajax({
        url: "http://localhost:8000/api/v1/auth/login?ajaxcall=ajaxcall&email="+$("#email").val()+"&password="+$("#password").val(),
        type: "POST",
        dataType : "json",
        /*data:{ajaxcall : "ajaxcall"},*/
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        success : function(data) {
            console.log(data["status"]);
            console.log(data["token"]);
            if(data["status"] == "success"){
                $("#token").val(data["token"]);
                $('#loginform').submit();
            }else{
                $(".form-error").text(data["status"]);
            }
        },
        error : function(data){
            alert(data);
        }


    })
    });
</script>
@stop
