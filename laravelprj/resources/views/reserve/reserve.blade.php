@extends('layouts.master')

@section('content')
    <div class="btn-group pull-right sort__forum">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            {!! icon('sort') !!} Sort by <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li class="active">createdate</li>
            <li class="">viewcount</li>
        </ul>
    </div>
    <div class="page-header">
        <a class="btn btn-primary pull-right" href="{{ route('articles.create') }}">
            {!! icon('forum') !!} {{ trans('forum.create') }}
        </a>
    </div>

    <div class="row container__forum">
        <div class="col-md-3 sidebar__forum">
            <aside>
                @include('articles.partial.search')
                @include('tags.partial.index')
            </aside>
        </div>

        <div class="col-md-9">
            <article>
                @forelse($articles as $article)
                    @include('reserve.partial.reserve', ['article' => $article])
                @empty
                    <p class="text-center text-danger">{{ trans('errors.not_found_description') }}</p>
                @endforelse

                <div class="text-center">
                    {!! $articles->appends(Request::except('page'))->render() !!}
                </div>
            </article>
        </div>
    </div>
    <div class="nav__forum">
        <a type="button" role="button" class="btn btn-sm btn-danger">{{ trans('forum.button_toc') }}</a>
    </div>
@stop
