<div class="media media__create" style="{{ isset($parentId) ? 'display:none;' : 'display:block;' }};margin-top: 10px">
    <div class="media-body">
        <form action="{{ route('comment.store') }}" method="POST" role="form" class="form-horizontal form-create-comment">
            {!! csrf_field() !!}
            <input type="hidden" name="board_id" value="{{ $board_id }}">
            @if(isset($parentId))
                <input type="hidden" name="parent_id" value="{{ $parentId }}">
            @endif
            <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}" style="width:100%; margin: auto;">
                <textarea name="content" class="form-control forum__content">{{ old('content') }}</textarea>
                {!! $errors->first('content', '<span class="form-error">:message</span>') !!}
            </div>
            <p class="text-right" style="margin:0;">
                <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 1rem;">
                    <i class="fa fa-paper-plane icon"></i>Save
                </button>
            </p>
        </form>
    </div>
</div>
