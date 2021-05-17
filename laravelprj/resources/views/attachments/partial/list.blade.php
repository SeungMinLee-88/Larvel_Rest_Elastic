@if ($attachments->count())
    <ul class="tags__forum">
        @foreach ($attachments as $attachment)
            <li id="file{{$attachment->id}}" class="btn btn-default">
                <i class="fa fa-download icon"></i>
                <a href="/attachments/{{ $attachment->name }}" class="btn btn-default">{{ $attachment->name }}</a>
                @if (auth()->user()->isAdmin() or $board->isWriter())
                    @if(Route::currentRouteName() == "board.edit")
                        <input type="button" onclick="javascript=editfile('{{$attachment->id}}');" value="x">
                    @endif
                @endif
            </li>
        @endforeach
    </ul>
@endif
