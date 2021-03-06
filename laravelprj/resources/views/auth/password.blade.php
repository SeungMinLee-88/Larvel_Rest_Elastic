@extends('layouts.master')
@section('content')
    <form action="{{ route('auth.postremind') }}" method="POST" role="form" class="form-auth">
        {!! csrf_field() !!}
        <h4>Password Remind
            <a href="/auth/login" class="btn btn-primary btn-sm" style="float: right;margin-bottom: 5px;">
                <i class="fa fa-undo"></i> Login
            </a>
        </h4>
        <p class="text-muted">
            Provide the same email address that you've registered and check your email inbox to reset the password.
        </p>
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}" autofocus>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>
        <button class="btn btn-primary btn-block" type="submit">Send Reminder</button>

    </form>
@stop
