    <div class="media media__item list-group-item" data-id="{{ $comment->id }}" style="margin-top: 10px">

        <div class="media-body">
            @if($currentUser and ($comment->isWriter() or auth()->user()->isAdmin()))
                @include('comments.partial.control')
            @endif

            <h4 class="media-heading">
            </h4>
            <p><i class="fa fa-user icon"></i> {{$comment->writer->email}}</p>
            <hr class="style2">
            <p>{!! markdown($comment->content) !!}</p>

            @if ($currentUser)

                <p class="text-right">
                    <button type="button" class="btn btn-info btn-sm btn__reply">
                        <i class="fa fa-clipboard"></i> reply
                    </button>
                </p>
            @endif

            @if($currentUser and ($comment->isWriter() or auth()->user()->isAdmin()))
                @include('comments.partial.edit')
            @endif

            @if($currentUser)
                @include('comments.partial.create', ['parentId' => $comment->id])
            @endif

            @forelse ($comment->replies as $reply)
                @include('comments.partial.comment', ['comment'  => $reply])
            @empty
            @endforelse
        </div>
    </div>
