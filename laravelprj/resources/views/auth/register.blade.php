<!-- resources/views/auth/register.blade.php -->
@extends('layouts.master')

@section('style')
    <style type="text/css">
        .treebtn {
            border:0;background-color:white;
        }
        #tree > table {
            width: 80%;
            margin-left:20px;
        }
        #selecta {
            text-align:left;
            color:black;
            text-decoration:none;
        }

        #selecta:hover {
            background: black;
            color: white;
        }
    </style>
@stop

@section('content')
    <div class="container" style="width: 570px">
    @include('auth.deptlist', ['returndepts' => $returndepts])

    <form action="{{ route('member.store') }}" method="POST" role="form" class="form-auth">

        {!! csrf_field() !!}

        <div class="page-header">
            <h4>Sign up
                <a href="/auth/login" class="btn btn-primary btn-sm" style="float: right; ">
                    <i class="fa fa-undo"></i> Login
                </a>
            </h4>

        </div>
        <div class="form-group">
            <input type="text" name="deptname" class="form-control" placeholder="department name" value="{{ old('deptname') }}" readonly/>
            {!! $errors->first('deptname', '<span class="form-error">:message</span>') !!}
        </div>
        <div class="form-group">
            <input type="hidden" name="deptcode" class="form-control" placeholder="department code" value="{{ old('deptcode') }}" readonly/>
        </div>

        <div class="form-group">
            <input type="text" name="name" class="form-control" placeholder="Full name" value="{{ old('name') }}"/>
            {!! $errors->first('name', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email address" value="{{ old('email') }}"/>
            {!! $errors->first('email', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password, minimum 6 chars"/>
            {!! $errors->first('password', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" />
            {!! $errors->first('password_confirmation', '<span class="form-error">:message</span>') !!}
        </div>

        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit">Sign up</button>
        </div>

    </form>
    </div>
@stop


@section('script')
    <script>
        function inputdept(deptname,deptcode){
            //alert('1');
            var deptname = deptname;
            var deptcode = deptcode;
            $('input[name=deptname]').val(deptname);
            $('input[name=deptcode]').val(deptcode);
        }

        function removeobj(depth,code){
            var tdval = "#id"+depth+code;
            var buttonval = tdval+"B";
            $(tdval).find("tr").remove();
            $(buttonval).attr("onclick", "javascript:ajaxfunction('"+depth+"','"+code+"');");
            $(buttonval).html('<span class="icon expand-icon glyphicon glyphicon-plus"></span>');
        }
        var paraMap = {"A":"1", "B":"2",
            "C":"3", "D":"4", "E":"5", "F":"6", "G":"7", "H":"8"};
        function ajaxfunction(depth,code){
            var depth = depth;
            var code = code;
            var appendval = "#id"+depth+code;
            var buttonval= appendval+"B";
            var tree = $('.tree');
            var tree = $('.tree');
            $(buttonval).attr("onclick", "removeobj('"+depth+"','"+code+"');");
            $(buttonval).html('<span class="icon expand-icon glyphicon glyphicon-minus"></span>');
            $(document).ready(function () {
                $.ajax({
                    type : "GET",
                    url : "/deptlist?depth="+depth+"&code="+code,
                    dataType : "json",
                    error : function(){
                        alert("통신실패!!!!");
                    },
                    success : function(data){
                        var length= data.length;
                        if (length != 0){
                            $.each(data, function(idx){
                                var idval = "id"+this.deptdepth+this.deptcode.replace(/0/g,'');
                                var test="";
                                var replacecode = this.deptcode.replace(/0/g,'');
                                test += "<tr><td id="+idval+">";
                                for(var i=0;i<=this.deptdepth;i++){
                                    test += "&nbsp;";
                                }
                                if(this.deptchild > 0){
                                    test += '<button class="treebtn" type="button" id="'+idval+'B" onclick="javascript:ajaxfunction(\'';
                                    test +=	this.deptdepth + '\' , \'' + replacecode +'\')">' +
                                        '<span class="icon expand-icon glyphicon glyphicon-plus"></span>';
                                }else{
                                    test += '<img src="/images/image/folder/treeline.jpg" width="15px">';
                                }
                                test +=	'</button>';
                                if(this.deptdepth >0 ){
                                    test +=
                                        '<a href="#" id="selecta" onclick="javascript:inputdept(\''+this.deptname+'\',\''+this.deptcode+'\')">';
                                    test +=	this.deptname;
                                    test +=	'</a>';
                                }else{
                                    test +=	this.deptname;
                                }
                                test +=	"</td></tr>";
                                $(appendval).append(test);
                            });
                        } else{
                        }
                    }
                });
            });
        }
    </script>
@stop
