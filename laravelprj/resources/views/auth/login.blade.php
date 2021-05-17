<!-- resources/views/auth/login.blade.php -->
@extends('layouts.master')

@section('content')
    <div class="container" style="width: 570px">
    <form action="{{ route('sessions.store') }}" method="POST" role="form" class="form-auth">

        {!! csrf_field() !!}

        <div class="page-header" style="margin-top:100px;">
            <h4>Login</h4>
        </div>

        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" autofocus/>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password">
            {!! $errors->first('password', '<span class="form-error">:message</span>')!!}
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Login</button>
        </div>

        <div class="description">
            <p>&nbsp;</p>
            <p class="text-center">Not a member? <a href="{{ route('auth.getremind')}}">Remind password</a></p>
            <p class="text-center">
                <a href="http://localhost:8000/auth/create" class="nav-link" style="padding-right: .5rem; padding-left: .5rem;"><i class="fa fa-certificate icon"></i> Sign up</a></p>
        </div>

    </form>
    </div>
    <div class="container" style="width: 570px">
    <form action="{{ route('sessions.store') }}" method="POST" role="form" class="form-auth">

        <div class="form-group">
            <a class="btn btn-default btn-block" href="{{ route('social/google') }}">
                <strong><i class="fa fa-google icon"></i> Sing Up with Google</strong>
            </a>
        </div>
    </form>
    </div>
@stop
