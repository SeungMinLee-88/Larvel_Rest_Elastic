<div class="list-group">
        <h4 class="media-heading">

            <a href="{{ route('board.show', $noticeboard->id) }}"  class="list-group-item" style="background: #b9b9b9;">
                @if ($noticeboard->isNoticed())
                    <span style="margin-right: 1rem;" title="{{ trans('common.notice') }}">
            {!! icon('pin', false) !!}
        </span>
                @endif<h4 class="list-group-item-heading" style="color: #9d0006">{{ $noticeboard->title }}</h4>

                @if ($noticeboard->solution_id)
        <span class="badge pull-right">
            {!! icon('check') !!} {{ trans('forum.solved') }}
        </span>
                @endif
            </a>
        </h4>

        <p class="list-group-item-text">
            <a href="{{ $noticeboard->writer->email }}" style="margin-right: 1rem;">
                {!! icon('member') !!} {{ $noticeboard->writer->name }}
            </a>
            {!! icon('clock') !!} {{ $noticeboard->created_at->diffForHumans() }}
        </p>
</div>
