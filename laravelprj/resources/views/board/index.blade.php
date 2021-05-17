@extends('layouts.master')

@section('content')

    <div class="btn-group pull-right sort__forum">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-sort icon"></i> Sort by
        </button>
        <ul class="dropdown-menu" role="menu">

            @foreach(['created_at' => 'create', 'title' => 'title'] as $column => $name)
            <li class="{{ Request::input('sortfield') == $column ? 'active' : '' }}">{!! link_for_sort($column, $name) !!}</li>
            @endforeach
        </ul>
    </div>
    <div class="page-header">
    </div>
    <div class="row container__forum">
        <div style="width: 100%">
            <article>
                @if($noticeboards)
                    @forelse($noticeboards as $noticeboard)

                        @include('board.partial.noticeboard', ['noticeboard' => $noticeboard])
                    @empty

                    @endforelse
                @endif
                @forelse($boards as $board)
                    @include('board.partial.board', ['board' => $board])
                @empty
                        <p class="text-center text-danger">{{ "There is no board record" }}</p>
                @endforelse

                <div class="text-center" style="padding-left: 50%">
                    {!! $boards->appends(Request::all())->links() !!}
                </div>

                    <div class="text-center">
                        <form action="{{ route('board.index') }}" id="search__board" class="navbar-form navbar-center" role="search">
                            <input type="hidden" class="searchfield" id="searchfield" name="searchfield" value="{{ Request::input('searchfield') }}" />
                            <div class="btn-group">
                            <button type="button" id="selectdsearchfield" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                                @if(Request::input('searchfield'))
                                {{ Request::input('searchfield') }}
                                @else
                                    Select
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                <li name="searchfield" class="dropdown-header"><a class="searchatag" href="javascript:void(0)" onclick="javascript:searchselect('title')">title</a></li>
                                <li name="searchfield" class="dropdown-header"><a class="searchatag" href="javascript:void(0)" onclick="javascript:searchselect('content')">content</a></li>
                                <li name="searchfield" class="dropdown-header"><a class="searchatag" href="javascript:void(0)" onclick="javascript:searchselect('writer')">writer</a></li>
                            </ul>
                            </div>
                            <div class="form-group">
                                <input type="text" id="search" name="search" value="{{ Request::input('search') }}"  class="form-control" placeholder="Search">
                            </div>
                            <button type="submit" id="searchsubmit" class="btn btn-secondary btn-sm">SEARCH</button>
                            <a class="btn btn-secondary btn-sm" href="/board" onclick="javascript:void(0)">RESET</a>
                        </form>
                    </div>
                    <div class="text-center">
                        <a class="btn btn-primary pull-right" href="{{ route('board.create') }}">
                            <i class="fa fa-weixin icon"></i> Write
                        </a>
                    </div>
            </article>
        </div>
    </div>
@stop
@section('script')
<script>
$("dropdown-header").on("click", function(e) {
    $("#searchfield").val("content");
});
function searchselect(keyword){
    var keyword = keyword;
    $("#searchfield").val(keyword);
    $("#selectdsearchfield").text(keyword);
}
$(document).ready(function(){
$("#searchsubmit").click(function(){
if($("#searchfield").val() == "" || $("#selectdsearchfield").text() == "select" || $("#searchtext").val() == "" ){
    return false;
}
});
});
</script>
@stop
