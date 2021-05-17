<div style="width: 100%">
<div class="list-group">
            <a href=""  class="list-group-item" style="padding: .75rem 1.25rem;padding-top: 0.75rem;padding-right: 1.25rem;padding-bottom: 0.75rem;padding-left: 1.25rem;">
                <h4 class="list-group-item-heading">
                    <p>
                    @if(isset($board["highlight"]["title"][0]))
                        {!! $board["highlight"]["title"][0] !!}
                    @else
                        {{ $board["_source"]["title"] }}
                    @endif
                    </p>
                </h4>
                <br><br>
            </a>
    <a href=""  class="list-group-item" style="padding: .75rem 1.25rem;padding-top: 0rem;padding-right: 0rem;padding-bottom: 0rem;padding-left: 1.25rem;">
    <p>
        @if(isset($board["highlight"]["content"][0]))
            {!! $board["highlight"]["content"][0] !!}
        @else
            {{ $board["_source"]["content"] }}
        @endif
    </p>
    </a>
        <p class="list-group-item-text">
                <i class="fa fa-member icon"></i> {{--{{ $board["_source"]["writer_id"] }}--}}
            {{ $board["_id"] }}<i class="fa fa-member icon"></i> {{ $board["_source"]["writer"] }}
            <i class="fa fa-clock-o icon"></i> {{ date('Y-m-d H:i:s', strtotime($board["_source"]["created_at"]))}}
        </p>

</div>
</div>
