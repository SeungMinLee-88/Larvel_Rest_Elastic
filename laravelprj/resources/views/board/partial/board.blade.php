<div style="width: 100%">
<div class="list-group">
        <h4 class="media-heading">

            <a href="{{ route('board.show', $board->id) }}"  class="list-group-item">
                <h4 class="list-group-item-heading">{{ $board->title }}</h4>
            </a>
        </h4>

        <p class="list-group-item-text">
                <i class="fa fa-member icon"></i> {{ $board->writer->name }}
            <i class="fa fa-clock-o icon"></i> {{ $board->created_at->diffForHumans() }}
        </p>
</div>
</div>
