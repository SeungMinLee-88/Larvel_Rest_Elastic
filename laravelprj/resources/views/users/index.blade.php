@extends('layouts.master')
@section('content')
<style type="text/css">
    .content_box{
        float:left;
        width:100%;
    }
    .left_bar{
        float:left;
        width:15%;
        background:#eaf4ff;
        height:100vh;
    }
    .right_bar{
        float:left;
        width:85%;
        padding:15px;
        height:100%;
    }
    .nav-tabs--vertical li{
        float:left;
        width:100%;
        padding:0;
        position:relative;
    }

    .nav-tabs--vertical li a{
        float:left;
        width:100%;
        padding: 15px;
        border-bottom:1px solid #adcff7;
        color:#1276F0;
    }

    .nav-tabs--vertical li a.active::after {
        content: "";
        border-color: #1276F0;
        border-style: solid;
        position: absolute;
        right: -8px;
        border-right: transparent;
        border-left: 15px solid transparent;
        border-right: 15px solid transparent;
        border-bottom: 16px solid #fff;
        border-top: 0;
        transform: rotate(270deg);
        z-index:999;
    }
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
                                <span class="glyphicon glyphicon-list"></span>User Lists
                                <div class="pull-right action-buttons" style="margin-left: 100px">
                                    <div class="btn-group pull-right">


                                        {!! link_for_filter("noapprove", "Not Approved") !!}

                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" style="padding: 0rem 0rem;">
                                            {!! icon('sort') !!} Sort by
                                        </button>
                                        <ul class="dropdown-menu slidedown">
                                            @foreach(['id' => 'id', 'name' => 'name' ] as $column => $name)
                                                <li class="{{ Request::input('sortfield') == $column ? 'active' : '' }}">{!! link_for_sort($column, $name) !!}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content_box">
                                <table class="table table-bordered" style="width:800px;">
                                    <thead>
                                    <tr>
                                        <th>Firstname</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Lastname</th>
                                        <th>Email</th>
                                        <th>Apply</th>
                                        <th>Process</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td style="align: center;margin: auto;text-align: center;">{{ $user->id}}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>{{ $user->email}}</td>
                                        <td>{{ $user->getuserRoles()[0]->name}}</td>
                                        <td>Doe</td>
                                        <td style="align: center;margin: auto;text-align: center;">{{ $user->approve}}</td>
                                        <td style="align: center;margin: auto;text-align: center;">
                                                    @if ($user->approve === "y")
                                                <a href="javascript:approvefunction('{{$user->id}}','n');">
                                                        <span class="glyphicon glyphicon-check"></span></a>
                                                    @elseif ($user->approve === "y")
                                                <a href="javascript:approvefunction('{{$user->id}}','y');">
                                                        <span class="glyphicon glyphicon-unchecked"></span></a>
                                                    @else
                                                <a href="javascript:approvefunction('{{$user->id}}','y');">
                                                        <span class="glyphicon glyphicon-unchecked"></span></a>
                                                    @endif
                                                <a href="javascript:void(0)" class="trash" onclick="javascript:deletefunction('{{$user->id}}');"><span class="glyphicon glyphicon-trash"></span></a>
                                        </td>
                                    </tr>
                                    @empty
                                    @endforelse
                                    <tr>
                                        <td colspan="7" style="align: center;margin: auto;text-align: center;">
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-6" style="padding-left: 330px;">
                                                        <div class="text-center">
                                                            {!! $users->appends(Request::all())->links() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
</div>
<script>
function approvefunction(userid, approve){
            var userid = userid;
            var approve = approve;
            $(document).ready(function () {
                $.ajax({
                    type : "GET",
                    url : "/admin/approveuser?userid="+userid+"&approve="+approve,
                    dataType : "json",
                    error : function(){
                        alert("통신실패!!!!");
                    },
                    success : function(data){
                        if(data["approve"] == "success"){
                        alert("user approve success");
                            location.reload(3000);
                        }
                    }
                });
            });
        }

function deletefunction(userid){
            var userid = userid;
            $(document).ready(function () {
                $.ajax({
                    type : "GET",
                    url : "/admin/deleteuser?userid="+userid,
                    dataType : "json",
                    error : function(){
                        alert("통신실패!!!!");
                    },
                    success : function(data){
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
