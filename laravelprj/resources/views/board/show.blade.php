@extends('layouts.master')

@section('content')
<div style="width: 100%">
    <div class="page-header">
        <a href="/board" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
            <i class="fa fa-undo"></i> List
        </a>
    </div>

    <div class="row container__forum">

        <div class="col-md-9" style="max-width: 100%; flex: 0 0 100%;">
            <article data-id="{{ $board->id }}" style="width: 100%">
                <article>
                    @include('board.partial.board', ['board' => $board])
                    @include('attachments.partial.list', ['attachments' => $board->attachments])
                    <p>
                        {!! markdown($board->content) !!}
                    </p>

                    @if (auth()->user()->isAdmin() or $board->isWriter())
                        <div class="text-center">
                            <a href="{{route('board.delete', $board->id)}}" class="btn btn-danger">
                                <i class="fa fa-trash-o icon"></i>Delete
                            </a>
                            <a href="{{route('board.edit', $board->id)}}" class="btn btn-info">
                                <i class="fa fa-pencil icon"></i> Edit
                            </a>
                        </div>
                    @endif
                </article>

                <article>
                    @include('comments.index', [
                      'owner'  => $currentUser && $board->isWriter()
                    ])
                </article>
            </article>
        </div>
    </div>
</div>
@stop
