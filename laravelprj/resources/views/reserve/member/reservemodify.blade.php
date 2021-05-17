@extends('layouts.master')

@section('content')
    <?php
    use App\Http\Controllers\MemberReserveController;
    $year ="";
    $month ="";
    $strYear = request()->input('year');
    $strMonth = request()->input('month');

    $year = request()->input('year') != null ? date("Y") : request()->input('year');
    $month = request()->input('month') != null ? date("m") : request()->input('month');
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
    $reservetime_curstr = implode(",", $reservetime_cur);
    ?>
    <div class="row container__forum">
        <div class="col-md-3 sidebar__forum">
            <aside>
                @include('layouts.partial.memberaside')
            </aside>
        </div>

        <div class="col-md-9">
            <article>
                <br>
                <table class="table">
                    <thead>
                    <tr>
                        <td align="left" style="">

                            <p class="lead" style="margin: 0px">
                                <i class="fa fa-clipboard"></i> {{$hall->hallname}} Hall
                            </p>
                        </td>

                    </tr>
                    </thead>
                </table>
                <table width="100%" class="table">
                    <tr>
                        <td height="60">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="center" >
                                        @if ($month > 1 && $month+1 > $curmonth)
                                            <a id="booktag" href="{{ route('member.reserveedit',["reserveid" => $reserveid, "userid" => $userid, "username" => $username, "hallid" => $hall->id, "hallname" => $hall->hallname, "reservedate" => $reservedate, "reservereason" => $reservereason, "reservetime_cur" => $reservetime_cur, "month" => $month-1])}}">
                                                <b>prev</b>
                                            </a>
                                        @else
                                        @endif
                                        &nbsp;|{{$year}}. {{$month}}|&nbsp
                                        @if ($month < 12)
                                            <a id="booktag" href="{{ route('member.reserveedit',["reserveid" => $reserveid, "userid" => $userid, "username" => $username, "hallid" => $hall->id, "hallname" => $hall->hallname, "reservedate" => $reservedate, "reservedate" => $reservedate, "reservereason" => $reservereason, "reservetime_cur" => $reservetime_cur, "month" => $month+1])}}">
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
                        <td valign='top' align='right' height='92px' bgcolor={{$backColor}} nowrap>

                            <p class={{$class}}>
                                {{$index}}
                            </p><br>
                            <?
                            $reservetime_total = array();
                            if($newLine != 0 && $newLine != 6) {
                            $reservelists = MemberReserveController::HallReserveList($hall->id ,$hall->hallname ,$inputDate);
                            foreach($reservelists as $reservelist){

                                $reservetimes =  $reservelist["reserve_time"];;
                                foreach($reservetimes as $reservetime)
                                {
                                    array_push($reservetime_total,$reservetime->id);
                                }
                            }
                            $reservetime_totalstr = implode(",", $reservetime_total);
                            $reservestatus = MemberReserveController::HallReserveStatusGet($hall->id ,$hall->hallname ,$inputDate);
                            $book_time_string = null;
                            ?>
                            <?
                            if($reservestatus["reservesum"] < 8 && $curDate >= $intToday){
                            ?>
                                <? if($reservestatus["restrictcnt"] > 0){?>
                                    <span color="#FF0000" style="font-weight: bold;color: #FF0000">Restricted</span>
                                    <?}else{?>
                                    <a id="booktag" href="javascript:void(0)" class="input"
                                       onclick="javascript:reservedateinput('{{$inputDate}}','{{$reservedate}}','{{$reservetime_totalstr}}','{{$reservetime_curstr}}');">
                                    <span color="black" style="font-weight: bold">
                                        <?if($inputDate == $reservedate){ ?>
                                            Modify
                                            <?}else{?>
                                            Reserve
                                            <?}?>
                                        </span>
                                        </a>
                                        <br>
                                <?}?>
                            <?}else{?>
                                <? if($reservestatus["restrictcnt"] > 0){?>
                                <span color="#FF0000" style="font-weight: bold;color: #FF0000">Restricted</span>
                                <?}else{?>
                                <?
                                if($reservestatus["reservesum"] >= 8 && $curDate >= $intToday && $inputDate == $reservedate){
                                ?>
                                <a id="booktag" href="javascript:void(0)" class="input"
                               onclick="javascript:reservedateinput('{{$inputDate}}','{{$reservedate}}','{{$reservetime_totalstr}}','{{$reservetime_curstr}}');">
                                     Modify
                                    </span>
                                    </a>
                                    <?
                                    }else{?>
                                    <br>
                                    <br>
                                    <?}?>
                                <?}?>
                            <?}?>
                        </td>
                        <?
                            }
                            else{
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
                @include('reserve.member.partial.modify')
            </article>
        </div>
    </div>
@stop


