@extends('layouts.master')
<style type="text/css">
    .trash { color:rgb(209, 91, 71); }
    .flag { color:rgb(248, 148, 6); }
    .panel-body { width:800px; }
    .panel-body { padding:0px; }
    .panel-footer .pagination { margin: 0; }
    .panel .glyphicon,.list-group-item .glyphicon { margin-right:5px; }
    .panel-body .radio, .checkbox { display:inline-block;margin:0px; }
    .panel-body input[type=checkbox]:checked + label { text-decoration: line-through;color: rgb(128, 144, 160); }
    .list-group-item:hover, a.list-group-item:focus {text-decoration: none;background-color: rgb(245, 245, 245);}
    .list-group { margin-bottom:0px; }


</style>
@section('content')

<div class="row container__forum">
        <div class="col-md-3 sidebar__forum">
            <aside>
                        @include('layouts.partial.'.strtolower(auth()->user()->getuserRoles()[0]["name"]).'aside')
            </aside>
        </div>

    <div class="col-md-9">
        <article>

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-body">
                            <div class="panel-heading" style="width:800px; ">
                                <span class="glyphicon glyphicon-list"></span>{{$hallname}} reserve Lists
                                <div class="pull-right action-buttons" style="margin-left: 100px">
                                    <div class="btn-group pull-right">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="padding: 0rem 0rem;">
                                            <i class="fa fa-sort icon"></i> Sort by
                                        </button>
                                        <ul class="dropdown-menu slidedown">
                                            @foreach(['reserve_date' => 'reservedate', 'id' => 'reserveid'] as $column => $name)
                                                <li class="{{ Request::input('sortfield') == $column ? 'active' : '' }}">{!! link_for_sort($column, $name) !!}</li>

                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item" style="border: 1px solid #FFFFFF; padding: 0rem 0rem;padding-top: 0rem;padding-right: 0rem;padding-bottom: 0rem;padding-left: 0rem;" >
                                        <div style="margin-left: 0px">
                                            Num
                                        </div>
                                        <div style="margin-left: 40px">
                                            Date
                                        </div>
                                        <div style="margin-left: 30px">
                                            Time
                                        </div>
                                        <div style="margin-left: 100px">
                                            Reason
                                        </div>
                                        <div style="margin-left: 110px">
                                            Hall
                                        </div>
                                        <div style="margin-left: 80px">
                                            User
                                        </div>

                                    </li>

                                </ul>

                            </div>
                            {{--{{$reservescount}}--}}
                            @forelse($reserves as $reserve)
                            <div class="panel-body" style="font-size: 13px;">
                                <ul class="list-group">
                                    <li class="list-group-item" style="padding: 0rem 0rem;padding-top: 0rem;padding-right: 0rem;padding-bottom: 0rem;padding-left: 0rem;">

                                        <div style="margin-left: 10px">
                                            {{$reserve->id}}
                                        </div>
                                        <div style="margin-left: 30px">
                                            {{$reserve->reserve_date}}
                                        </div>
                                        <div style="margin-left: 20px">
                                            @forelse($reserve->reservetime as $reservetime)
                                            {{str_replace("|", "~",$reservetime->reservetime)}}<br>
                                            @empty
                                            @endforelse
                                        </div>
                                        <div style="word-break:break-all;margin-left: 10px;width:180px;text-align: center">
                                            {{$reserve->reserve_reason}}
                                        </div>
                                        <div style="margin-left: 20px">
                                            {{$reserve->hall->hallname}}
                                        </div>
                                        <div style="word-break:break-all;margin-left: 40px;width:180px;text-align: center">
                                            {{$reserve->user->name}}
                                        </div>
                                        <div class="pull-right action-buttons" style="margin-left: 700px">
                                            <a href="{{ route('admin.reserveedit',["reserveid" => $reserve->id, "userid" => $reserve->user->id, "username" => $reserve->user->name, "hallid" => $reserve->hall->id, "hallname" => $reserve->hall->hallname, "reservedate" => $reserve->reserve_date, "reservereason" => $reserve->reserve_reason, "month" => date("m",strtotime($reserve->reserve_date))])}}"><span class="glyphicon glyphicon-pencil"></span></a>
                                            <a href="javascript:void(0)" class="trash" onclick="javascript:ajaxfunction('{{$reserve->id}}');"><span class="glyphicon glyphicon-trash"></span></a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            @empty
                                <p class="text-center text-danger">{{ "There is no reserve record" }}</p>
                            @endforelse
                            <div class="panel-body" style="width: 100%">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>
                                            Total Count <span class="label label-info">{{$reservescount}}</span></h6>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="text-center">
                                            {!! $reserves->appends(Request::all())->links() !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            </div>
        </article>
    </div>
</div>
@stop
@section('script')
<script>
function ajaxfunction(reserveid){
            var reserveid = reserveid;
            $(document).ready(function () {
                $.ajax({
                    type : "GET",
                    url : "/admin/reservedelete?reserveid="+reserveid,
                    dataType : "json",
                    error : function(){
                        alert("통신실패!!!!");
                    },
                    success : function(data){
                    //alert(data["deleted"]);
                        if(data["deleted"] == "success"){
                        alert("reserve delete success");
                        location.reload(3000);
                        }
                    }

                });
            });

        }


</script>
@stop
