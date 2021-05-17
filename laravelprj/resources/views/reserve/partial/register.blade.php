<body style="background: #ffffff;">
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
<form name="reserveform" id="reserveform" action="{{ route('admin.reservestore')}}" method="post">
    {!! csrf_field() !!}
    <input type="hidden" name="hall_id" value="{{$hall->id}}">
    <div id="book_content" align="center" style="width:850px;">
        <table width="700px"  style="margin-left:20px;"  align="center" border="0">
            <tr>
                <td bgcolor="#f5f5f5" align="center">
                    DATE
                </td>
                <td>
                    <input type="text" name="reserve_date" id="reserve_date" value="{{ old('reserve_date') }}" style="width:100%; ;height:100%;border: 0;">
                    {!! $errors->first('reserve_date', '<span class="form-error">:message</span>') !!}
                </td>
            </tr>
            <tr>
                <td bgcolor="#f5f5f5" align="center">
                    USER
                </td>
                <td>
                    <input type="text" name="user_name" value="{{ old('user_name') }}" onclick="javascript:openUserList()" style="width:100%; border: 0;" readonly/>
                    <input type="hidden" name="user_id" value="{{ old('user_id') }}" style="width:100%; border: 0;"
                           placeholder="please select user." onclick="javascript:openUserList()" readonly>
                </td>
            </tr>

            <tr>
                <td bgcolor="#f5f5f5" align="center">
                    REASON
                </td>
                <td>
                    <textarea name="reserve_reason" value="" rows=5 style="width:100%; height:100%; border: 0;">{{ old('reserve_reason') }}</textarea>
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
    function reservedateinput(date,reservetime_string){

    var checkboxlen = $('input:checkbox[name="reservetime[]"]').length;

    for (var j = 1; j < checkboxlen; j++){
        $('#'+j).prop("disabled",false);
    }

    var chk = document.getElementsByName("reservetime");
    var disablearr = [ "1", "2", "3", "4", "5", "6", "7","8" ];
    for(j=0;j<chk.length;j++){
    chk[j].disabled=false;
    }
    for (var k = 0; k < disablearr.length; k++){
    parent.document.getElementById(disablearr[k]+"label").style.backgroundColor="";
    }
    var reservetime_list  = reservetime_string;
    var reservetime_array = new Array();
    var date = date;
    $('#reserve_date').val(date);
    if(reservetime_string != 'null' && reservetime_string != '') {
    reservetime_array = reservetime_list.split(",")
    for (var i = 0; i < reservetime_array.length; i++){
    $('#'+reservetime_array[i]).prop("disabled",true);
    $('#'+reservetime_array[i]+"label").css("backgroundColor","#FA5858");
    }
    }
}
    function openUserList(){
        var dataval = document.reserveform.reserve_date.value;
        if (dataval==""){
            alert("Please select reserve date.");
            return false;
        }
        var url="/admin/userlist?close=n"
        open(url, "confirm", "toolbar=no,location=no,"
            +"status=no,menubar=no,"
            +"scrollbars=yes,resizable=no,"
            +"width=410,height=800");
    }
</script>
@stop
