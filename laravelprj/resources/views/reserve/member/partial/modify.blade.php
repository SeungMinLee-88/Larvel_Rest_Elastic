<style type="text/css">
    input[class="checkbar"] + label {
        display: inline-block;
        width: 100%;
        height: 100%;
        border:1px solid #D8D8D8;
        background-color: #FFFFFF;
        cursor: pointer;
    }
    input[class="checkbar"]:checked + label {
        background-color: #A4A4A4;
    }
    input[class="checkbar"] {
        display: none;
    }
    #admin_form{
        margin-left:200px;
        margin-top: 40px;
        position:relative;
        display: inline-block;
        clear:both;
    }
    .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
        padding: 3px;
    }
</style>
<form name="reserveform" id="reserveform" action="{{ route('member.reserveedit',["reserve_id" => $reserveid])}}" method="post">
    {!! csrf_field() !!}
    <input type="hidden" name="hall_id" value="{{$hall->id}}">
    <div id="book_content" align="center" style="width:850px;">
        <table width="700px"  style="margin-left:20px;"  align="center" border="0">
            <tr>
                <td bgcolor="#f5f5f5" align="center">
                    DATE :
                </td>
                <td>
                    <input type="text" name="reserve_date" id="reserve_date" value="" style="width:100%; border: 0;" readonly>
                </td>
            </tr>
            <tr>
                <td bgcolor="#f5f5f5" align="center">
                    USER
                </td>
                <td>
                    <input type="text" name="user_name" value="{{$username}}" style="width:100%; border: 0;"/>
                    <input type="hidden" name="user_id" value="{{$userid}}" style="width:100%; border: 0;" readonly>
                </td>
            </tr>

            <tr>
                <td bgcolor="#f5f5f5" align="center">
                    RASON
                </td>
                <td>
                    <textarea name="reserve_reason" rows=5 style="width:100%; height:100%; border: 0;">{{$reservereason}}</textarea>
                </td>
            </tr>
        </table>

        <table width="900px"  style="margin-left:20px;border-collapse: collapse;"  align="center" border="0">
            <tr>
                <td bgcolor="#f5f5f5" align="center" colspan="8">
                    TIME
                </td>
            </tr>
            <tr>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="1" value="1"/>
                    <label for="1" id="1label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        09:00 ~ 10:00
                    </label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="2" value="2"/>
                    <label for="2" id="2label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        10:00 ~ 11:00</label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="3" value="3"/>
                    <label for="3" id="3label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        11:00 ~ 12:00</label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="4" value="4"/>
                    <label for="4" id="4label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        13:00 ~ 14:00</label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="5" value="5"/>
                    <label for="5" id="5label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        14:00 ~ 15:00</label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="6" value="6"/>
                    <label for="6" id="6label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        15:00 ~ 16:00</label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="7" value="7"/>
                    <label for="7" id="7label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        16:00 ~ 17:00</label>

                </td>
                <td height="30px">
                    <input type="checkbox" class="checkbar" name="reservetime[]" id="8" value="8"/>
                    <label for="8" id="8label" style="text-align:center;vertical-align:middle;font-size:12px;">
                        17:00 ~ 18:00</label>

                </td>

            </tr>
        </table>
        <table width="900px"  style="margin-left:20px;"  align="center" border="0">
            <tr>
                <td height="10px" colspan="3">

                </td>
            </tr>
            <tr>
                <td align="center" colspan="3">
                    <a href="javascript:void(0)" class="submit" onclick="">
                        <i class="fa fa-check-circle fa-w-14 fa-2x"></i>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</form>
@section('script')
<script>
    $(document).ready(function(){
        $(".checkbar").click(function() {
            var dataval = document.reserveform.reserve_date.value;
            if (dataval==""){
                alert("Please Input Reserve Date.");
                return false;
            }
        });
        $(".submit").click(function() {
            var checkboxlen = $('input:checkbox[name="reservetime[]"]:checked').length;
            if (checkboxlen == 0){
                alert("Please Input Reserve Time.");
                return false;
            }else{
                document.getElementById('reserveform').submit();
            }
        });
    });
    function reservedateinput(date, reservedate, reservetime_totalstr, reservetime_curstr){
        var checkboxlen = $('input:checkbox[name="reservetime[]"]').length;
        var chk = document.getElementsByName("reservetime");
        var disablearr = [ "1", "2", "3", "4", "5", "6", "7","8" ];
        $('#reserve_date').val(date);
        for (var dis = 1; dis <= checkboxlen; dis++){
            $('#'+dis).prop("disabled",false);
            $('#'+dis).prop("checked",false)
        }
        for (var bgc = 0; bgc < disablearr.length; bgc++){
            $('#'+disablearr[bgc]+"label").css('backgroundColor', '');
        }
        var reservetime_totalstr_list  = reservetime_totalstr;
        var reservetime_totalstr_array = new Array();
        reservetime_totalstr_array = reservetime_totalstr_list.split(",")
        var reservetime_curstr_list  = reservetime_curstr;
        var reservetime_curstr_array = new Array();
        reservetime_curstr_array = reservetime_curstr_list.split(",")
        var date = date;
        var reservedate = reservedate;
        if(date == reservedate) {
            alert('Current reserve date.');
            for (var i = 0; i < reservetime_totalstr_array.length; i++){

                var chkid = "#"+reservetime_totalstr_array[i];
                $(chkid).prop("disabled",true);
                $("#"+reservetime_totalstr_array[i]+"label").css('backgroundColor', '#FA5858');
            }

            for (var j = 0; j < reservetime_curstr_array.length; j++){
                //alert('2');
                $("#"+reservetime_curstr_array[j]).prop("disabled",false);
                $("#"+reservetime_curstr_array[j]+"label").css('backgroundColor', '');
                $("#"+reservetime_curstr_array[j]).prop("checked",true);
            }
        }else{
            if(reservetime_totalstr != 'null' && reservetime_totalstr != '') {
                for (var i = 0; i < reservetime_totalstr_array.length; i++){
                    //alert("reservetime_curstr_array : "+'#'+reservetime_totalstr_array[i]);
                    $('#'+reservetime_totalstr_array[i]).prop("disabled",true);
                    $("#"+reservetime_totalstr_array[i]+"label").css('backgroundColor', '#FA5858');
                }
            }
        }
    }
</script>
@stop
