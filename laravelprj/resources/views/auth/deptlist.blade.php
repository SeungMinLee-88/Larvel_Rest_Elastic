
<div class="page-header" style="margin-top:100px;">
    <h4>Select Dept</h4>
</div>
<div id="outline" style="border: 1px solid black;widht:380px;height:500px;">

        <div id="tree">
            <table border=0 cellpadding=0 cellspacing=0>
                <tr>
                    <td id="id0A">
                        <button class="treebtn" type="button" id="id0AB"
                                onclick="javascript:ajaxfunction('{{$returndepts[0]["deptdepth"]}}','{{ str_replace('0','',$returndepts[0]["deptcode"])}}')">
                            <span class="icon expand-icon glyphicon glyphicon-plus"></span></button>
                        <span class="icon node-icon glyphicon glyphicon-user"></span> {{$returndepts[0]["deptname"]}}
                    </td>
                </tr>
            </table>
        </div>
    </div>
