@extends('layouts.master')
<div class="page-header" style="margin-top:100px;">
    <h4>Select User</h4>
</div>
<div id="outline" style="border: 1px solid black;widht:380px;height:500px;">
    <div id="tree">
        <table border=0 cellpadding=0 cellspacing=0>
            <tr>
                <td id="id0A">
                    <button class="treebtn" type="button" id="id0AB"
                            onclick="javascript:ajaxfunction('{{$deptusers[0]["deptdepth"]}}','{{ str_replace('0','',$deptusers[0]["deptcode"])}}','0')">
                        <span class="icon expand-icon glyphicon glyphicon-plus"></span></button>
                    <span class="icon node-icon glyphicon glyphicon-user"></span> {{$deptusers[0]["deptname"]}}
                </td>
            </tr>
        </table>
    </div>
</div>
<script>
    function inputuser(userid, username){
        var userid = userid;
        var username = username;
        opener.document.reserveform.user_id.value=userid;
        opener.document.reserveform.user_name.value=username;
        self.close();
    }
    function inputdept(deptname,deptcode){
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

    function removeobj2(depth,idval,depcode,child){
        var tdval = "#"+idval;
        var buttonval = "#"+idval+"B";
        var child = child;
        var replacecode = depcode.replace(/0/g,'');
        $(tdval).find("tr").remove();
        if (child < 1 ){
            $(buttonval).attr("onclick", "javascript:ajaxfunction('"+depth+"','"+replacecode+"');ajaxfunction2('"+depth+"','"+idval+"','"+depcode+"','"+child+"');");
            $(buttonval).html('<span class="icon expand-icon glyphicon glyphicon-minus"></span>');
        }else if(child >= 1){
            $(buttonval).attr("onclick", "javascript:ajaxfunction('"+depth+"','"+replacecode+"');ajaxfunction2('"+depth+"','"+idval+"','"+depcode+"','"+child+"');");
            $(buttonval).html('<span class="icon expand-icon glyphicon glyphicon-plus"></span>');
        }
    }

    var paraMap = {"A":"1", "B":"2",
        "C":"3", "D":"4", "E":"5", "F":"6", "G":"7", "H":"8"};
    function ajaxfunction(depth,code,child){
        var depth = depth;
        var code = code;
        var appendval = "#id"+depth+code;
        var buttonval= appendval+"B";
        if(child =="0"){
            $(buttonval).attr("onclick", "removeobj('"+depth+"','"+code+"');");
            $(buttonval).html('<span class="icon expand-icon glyphicon glyphicon-minus"></span>');
        }
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
                            var child = "";
                            test += "<tr><td id="+idval+">";
                            for(var i=0;i<=this.deptdepth;i++){
                                test += "&nbsp;";
                            }
                            if(this.deptchild > 0 && this.userchild == 0){
                                test += '<button class="treebtn" type="button" id="'+idval+'B" onclick="javascript:ajaxfunction(\'';
                                test +=	this.deptdepth + '\' , \'' + replacecode +'\')">' +
                                    '<span class="icon expand-icon glyphicon glyphicon-plus"></span>';
                            }else if(this.deptchild == 0 && this.userchild > 0){
                                child =1;
                                test += '<button class="treebtn" type="button" id="'+idval+'B" onclick="javascript:ajaxfunction2(\'';
                                test +=	this.deptdepth + '\', \'' + idval + '\' , \'' + this.deptcode +'\',\''+ child+'\')"><span class="icon expand-icon glyphicon glyphicon-plus"></span>';
                            }else if(this.deptchild >  0 && this.userchild > 0){
                                child =2;
                                test += '<button class="treebtn" type="button" id="'+idval+'B" onclick="javascript:ajaxfunction(\'';
                                test +=	this.deptdepth + '\' , \'' + replacecode +'\');ajaxfunction2(\'';
                                test +=	this.deptdepth + '\', \'' +idval + '\' , \'' + this.deptcode +'\',\''+child+'\')"><span class="icon expand-icon glyphicon glyphicon-plus"></span>';
                            }else {
                                test += '<img src="/images/image/folder/treeline.jpg" width="15px">';
                            }
                            test +=	'</button>';
                            test +=	this.deptname;
                            test +=	"</td></tr>";
                            $(appendval).append(test);
                        });
                    } else{

                    }
                }
            });
        });
    }

    function ajaxfunction2(depth,idval,depcode,child){
        var child = child;
        var depth = depth;
        var nbspdepth = parseInt(depth)+4;
        var appendval = "#"+idval;
        var depcode = depcode;
        var replacecode = depcode.replace(/0/g,'');
        var buttonval= "#id"+depth+depcode.replace(/0/g,'')+"B";
        if(child =="1" || child == "2"){
            $(buttonval).attr("onclick", "removeobj2('"+depth+"','"+idval+"','"+depcode+"','"+child+"');");
            $(buttonval).html('<span class="icon expand-icon glyphicon glyphicon-minus"></span>');
        }
        $(document).ready(function () {
            $.ajax({
                type : "GET",
                url : "/userlist?depcode="+depcode,
                dataType : "json",
                error : function(){
                    alert("통신실패!!!!");
                },
                success : function(data){
                    var length= data.length;
                    $.each(data, function(idx){
                        var test="";
                        test += "<tr><td>";
                        for(var i=0;i<=nbspdepth;i++){
                            test += "&nbsp;";
                        }
                        test += '<img src="/images/image/folder/treeline.jpg" width="15px">';
                        test += '<span class="icon node-icon glyphicon glyphicon-member"></span>';
                        test +=	'<b id="selectb" onclick="javascript:inputuser(\''+this.usernum+'\', \''+this.username+'\')">';
                        test +=	this.username +"</b>";
                        test +=	"</td></tr>";
                        $(appendval).append(test);
                    });
                }
            });
        });
    }
</script>
