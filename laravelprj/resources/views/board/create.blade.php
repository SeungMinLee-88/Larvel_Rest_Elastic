@extends('layouts.master')

@section('content')
    <div class="page-header">
        <a href="/board" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
            <i class="fa fa-undo"></i> List
        </a>
    </div>

    <div class="container__forum">
        <form action="{{ route('board.store') }}" method="POST" role="form" class="form__forum">
            {!! csrf_field() !!}
            @include('board.partial.form')
            <div class="form-group">
                <p class="text-center">
                    <a href="{{ route('board.create') }}" class="btn btn-default">
                        {!! icon('reset') !!} Reset
                    </a>
                    <button type="submit" class="btn btn-primary my-submit">
                        {!! icon('plane') !!} Post
                    </button>
                </p>
            </div>
        </form>
    </div>
@stop
