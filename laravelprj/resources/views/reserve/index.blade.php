@extends('layouts.master')

    @section('content')
    <?php
        use App\Http\Controllers\AdminReserveController;
    $year ="";
    $month ="";
    $strYear = request()->input('year');
    $strMonth = request()->input('month');
    $year = request()->input('year') != null ? date("Y") : request()->input('year');
    $month = request()->input('month') != null ? date("m") : request()->input('month');

    ini_set('date.timezone', 'Asia/Seoul');

    $date = date("Y-m-d");
    $curmonth = date("m");
    $curmonth = $curmonth;


    if($strYear == ""){
      $year = date("Y");
    }else{
        $year = $strYear;
    }
    if($strMonth == ""){
        $month = date("m");
    }else{
        $month = $strMonth;
    }

    $month = strlen($month) == 1 ? "0".$month : $month;
    $a_date = date("ym");
    $dayofweek = date('w', strtotime($year.$month."01"));

    $endday = date("t", strtotime($year.$month));
    $intToday = date('Ymd');
    ?>

<div class="row container__forum">
        <div class="col-md-3 sidebar__forum">
            <aside>

                @include('layouts.partial.'.strtolower(auth()->user()->getuserRoles()[0]["name"]).'aside')
            </aside>
        </div>
    <div class="col-md-9">
    <article>
        <style type="text/css">
            .table > thead > tr > th, .table > thead > tr > td, .table > tbody > tr > th, .table > tbody > tr > td, .table > tfoot > tr > th, .table > tfoot > tr > td {
                padding: 3px;
            }
        </style>
        <table class="table">
            <thead>
            <tr>
                <td align="left" style="">

                    <p class="lead" style="margin: 0px">
                        <i class="fa fa-clipboard"></i> {{$hall->hallname}} Hall
                    </p>
                </td>
                <td align="right" style="">
                    <a href="javascript:void(0)" onclick="javascript:location.href='/admin/reserve?hallid={{$hall->id}}'">
                        TODAY
                    </a>
                </td>
            </tr>
            </thead>
        </table>
        <table width="100%" class="table">
            <tr>
                <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="center" style="padding: 0.0rem;" colspan="2">

                                @if ($month > 1 && $month+1 > $curmonth)
                                <a id="booktag" href="{{ route('admin.reserve',["hallid" => $hall->id, "hallname" => $hall->hallname, "year" => $year, "month" => $month-1])}}">
                                    <b>prev</b>
                                </a>
                                @else

                                @endif
                                |{{$year}}. {{$month}}|&nbsp
                                @if ($month < 12)
                                <a id="booktag" href="{{ route('admin.reserve',["hallid" => $hall->id, "hallname" => $hall->hallname, "year" => $year, "month" => $month+1])}}">
                                    <b>next</b>
                                </a>
                                @else
                                @endif

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </thead>
    </table>
    <table class="table">
            <thead>
            <tr bgcolor="#CECECE">
                <td>
                    <div align="center"><span style="color: red">SUN</span></div>
                </td>
                <td>
                    <div align="center">MON</div>
                </td>
                <td>
                    <div align="center">TUE</div>
                </td>
                <td>
                    <div align="center">WED</div>
                </td>
                <td>
                    <div align="center">THU</div>
                </td>
                <td>
                    <div align="center">FRI</div>
                </td>
                <td>
                    <div align="center"><span style="color: blue">SAT</span></div>
                </td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <?
                $newLine=0;
                for($index = 0; $index < $dayofweek; $index++){
                 $newLine++;
                 ?>
                    <td >&nbsp;</td>
                <?
                    }
                    for($index = 1; $index <= $endday; $index++)
                    {
        $sUseDate = $year;
        $sUseDate .= strlen($month+1) == 1 ? $month : $month;
        $sUseDate .= strlen($index) == 1 ? "0".$index : $index;
        $curDate = $sUseDate;
		$inputDate = $year."-";
		$inputDate .= strlen($month+1) == 1 ? $month : $month;
		$inputDate .= "-";
        $inputDate .= strlen($index) == 1 ? "0".$index : $index;
        $iUseDate = $sUseDate;
	       $backColor = "";
	       $color="balck";
	       if($newLine == 0){
               $backColor = "#F6CECE";
               $class = "text-danger";
           }else if($newLine == 6){
               $backColor = "#529dbc";
               $class = "text-primary";
           }else{
               $backColor = "white";
               $class = "text-dark";
           }
	       if($iUseDate == $intToday ) {
               $backColor = "#c9c9c9";
           }
                    ?>
                    <td valign='top' align='right' height='62px' bgcolor={{$backColor}} nowrap>

                        <p class={{$class}}>
                            {{$index}}
                        </p><br>
                        <?
                        $reservetime_string = "";
                    if($newLine != 0 && $newLine != 6) {
                        $reservelists = AdminReserveController::HallReserveList($hall->id ,$hall->hallname ,$inputDate);
                        $reservetime_arr = array();
                        foreach($reservelists as $reservelist){

                            $reservetimes =  $reservelist["reserve_time"];;
                            foreach($reservetimes as $reservetime)
                            {
                                array_push($reservetime_arr,$reservetime->id);
                            }
                        }
                        $reservetime_string = implode(",", $reservetime_arr);
                        //echo $reservetime_string;
                        $reservestatus = AdminReserveController::HallReserveStatusGet($hall->id ,$hall->hallname ,$inputDate);
                       $book_time_string = null;
                        ?>
                        <?
                        if($reservestatus["reservesum"] < 8 && $curDate >= $intToday){
                        ?>
                        <?if($reservestatus["restrictcnt"] == 0){ ?>
                        <a id="booktag" href="javascript:void(0)" class="input"
                               onclick="javascript:reservedateinput('{{$inputDate}}','{{$reservetime_string}}');">
                            <span color="black" style="font-weight: bold">
                                Reserve
                            </span>
                        </a>
                        <br>
                        <a href="/admin/restrictreserve?hall_id={{$hall->id}}&hallname={{$hall->hallname}}&inputDate={{$inputDate}}&month={{$strMonth}}"
                           id="booktag" class="input">
                            <span style="font-weight: bold;color: #04B404">
                                Restrict
                            </span>
                        </a>
                        <?}else if($reservestatus["restrictcnt"] >= 1) {?>
                        <a href="/admin/unrestrictreserve?hall_id={{$hall->id}}&hallname={{$hall->hallname}}&inputDate={{$inputDate}}&month={{$strMonth}}"
                           id="booktag" class="input" onclick="">
                            <span color="#FF0000" style="font-weight: bold;color: #FF0000">
                                Cancel
                                <br>Restricted
                            </span>
                        </a>
                        <?} ?>
                        <?
                        }else{
                         ?>
                         <br>
                         <br>
                         <span color="red" style="font-weight: bold"></span>
                         <?
                         }
                         ?>
                    </td>
                    <?
                    }else{
                    ?>
                    </td>
                    <?
                    }
                    $newLine++;
                    if($newLine == 7)
                    {
                        echo "</tr>";
                        if($index <= $endday)
                        {
                            echo "<tr>";
                        }
                        $newLine=0;
                    }
                    ?>
                <?
}
?>
            </tr>
            </tbody>
        </table>
            @include('reserve.partial.register', ['reservetimes' => $reservetimes])
        </article>
    </div>
</div>
@stop


