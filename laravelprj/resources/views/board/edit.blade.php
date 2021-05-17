@extends('layouts.master')

@section('content')
    <div class="page-header">
        <a href="/board" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
            <i class="fa fa-undo"></i> List
        </a>
    </div>

    <div class="container__forum">
        <form action="{{ route('board.update', $board->id) }}" method="POST" role="form" class="form__forum">
            {!! csrf_field() !!}
            {!! method_field('PUT') !!}

            @include('board.partial.form')

            <div class="form-group">
                <p class="text-center">
                    <a href="{{ route('board.edit', $board->id) }}" class="btn btn-default">
                        {!! icon('reset') !!} Reset
                    </a>
                    <button type="submit" class="btn btn-primary">
                        {!! icon('plane') !!} Edit
                    </button>
                </p>
            </div>
        </form>
    </div>
@stop
