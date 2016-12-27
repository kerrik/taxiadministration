<?php

/*
   Calendarclass based on Simple Calendar
   by Karlis Blumentals (www.blumentals.net)

   Displays a calendar, one month at a time.
   Selected date is passed as parameter txi_day=yyyy-mm-dd
   e.g. myscript.php?txi_day=2004-10-30
*/
class txi_calendar{
    private $txi_day;
    private $txi_month;
    private $txi_year;
    private $txi_days=array();
    private $txi_offset;
    private $days_in_month;

   function __construct(){
      // parse days
      if (isset($_GET['txi_date'])) {
        list($yr, $mo, $da) = explode('-', $_GET['txi_date']);
        $this->txi_day = intval($da);
        $this->txi_month = intval($mo);
        $this->txi_year = intval($yr);
      }else{
        $this->txi_month = date('m');
        $this->txi_day = date('d');
        $this->txi_year = date('Y');
      }
      $this->days_in_month = cal_days_in_month(CAL_GREGORIAN, $this->txi_month, $this->txi_year);
     // print_r($this);
      //check whitch day of the week the month starts
      // it must have a value in range 1..7
      $this->txi_offset = date('w', mktime(0,0,0,$this->txi_day,1,$this->txi_year));
      if ($this->txi_offset == 0) $this->txi_offset = 7;
      //Fill array with name of days
   }

    function txi_date(){
        echo "$this->txi_year-$this->txi_month-$this->txi_day";
    }
    function txi_day_name( $short){

      $day_length=(!$short)? 'l' : 'D';
      _e( date( $day_length,mktime(0,0,0,$this->txi_month,$this->txi_day, $this->txi_year ) ) ) ;
    }
    function txi_month_name($short ){
      $day_length=(!$short)? 'F' : 'M';
      echo date( $day_length,mktime(0,0,0,$this->txi_month,$this->txi_day,  $this->txi_year ));
     // _e( date( $day_length,mktime(0,0,0,$this->txi_month,$this->txi_day,  $this->txi_year ) ) ) ;
    }
    function txi_year(){
      _e( $this->txi_year );
    }
    function prev_month(){
        echo('<a href="?txi_date='.date('Y-m-d', mktime(0,0,0,$this->txi_month,0,$this->txi_year)).'">&laquo;</a>');
    }
    function next_month(){
      echo('<a href="?txi_date='.date('Y-m-d', mktime(0,0,0,$this->txi_month+1,1,$this->txi_year)).'">&raquo;</a>');
    }
    function tur_cal_print_days_in_month(){
    for ($counter1=1;$counter1<=$this->days_in_month;$counter1++){
        echo nl2br( "<div class='date' id='day" . $counter1 . "'>" . $counter1 ."</div>\n") ;
    }//end for
} //end tur_cal_print_days_in_month
    function tur_cal_print_drivers($tid,$pass){
        $tid=($pass==0)?'05-17':'17-05';
        for ($counter1=1;$counter1<=$this->days_in_month;$counter1++){
            echo nl2br( "<div class='calendarpost'> <span class='bil"."'>Driver</span><span class='calendarpost_rightadj'>".$tid."</span></div>\n");
        }//end for
    } //end tur_cal_print_days_in_month
}

/*
// date ok flag
$dateok = false;

// parse parameter
if (isset($GLOBALS['day'])) {
  list($yr, $mo, $da) = explode('-', $_GET['day']);
  $yr = intval($yr);
  $mo = intval($mo);
  $da = intval($da);
  if (checkdate($mo, $da, $yr)) $dateok = true;
}

// if invalid date selected then selected date = today
if (!$dateok) {
  $mo = date('m');
  $da = date('d');
  $yr = date('Y');
}

 <div id="main" class="wrapper">
   2013-04-07<br>tor<br>Apr<table border="1" cellpadding="3" cellspacing="0" width="200"><tr>
   <td colspan="1" align="center" class="linkbar"><a href="?dag=2011-01-01">&laquo;</a></td>
   <td colspan="5" align="center" class="linkbar"><p class="calendar">2012</p></td>
   <td colspan="1" align="center" class="linkbar"><a href="?dag=2013-01-01">&raquo;</a></td></tr>
<tr><td colspan="1" align="center" class="linkbar2"><a href="?dag=2011-12-31">&laquo;</a></td>
<td colspan="5" align="center" class="linkbar2"><p class="calendar">January</p></td>
<td colspan="1" align="center" class="linkbar2"><a href="?dag=2012-02-01">&raquo;</a></td></tr>
<tr><td width="14%" style="font-weight: normal">&nbsp;</td>

// days in month
$nd = date('d', mktime(0,0,0,$mo+1,0,$yr));

// days array
$days = array();

// reset array
for ($i=0;$i<=42;$i++) $days[$i]['out']= '&nbsp;';

// fill days array
// valid days contain data, invalid days are left blank
$j=1;
for ($i=$offset;$i<=($offset+$nd-1);$i++) {
  $day = $j++;
  $date = $yr.'-'.$mo.'-'.$day;
  $days[$i]['out']= '<a href="?day='.$date.'">'.$day.'</a>';
  $days[$i]['dat']= $date;
}

// output table
echo('<table border="1" cellpadding="3" cellspacing="0" width="200">');
echo('<tr>');
echo('<td colspan="1" align="center" class="linkbar"><a href="?day='.date('Y-m-d', mktime(0,0,0,$mo,$da,$yr-1)).'">&laquo;</a></td>');
echo('<td colspan="5" align="center" class="linkbar"><p class="calendar">'.$yr.'</p></td>');
echo('<td colspan="1" align="center" class="linkbar"><a href="?day='.date('Y-m-d', mktime(0,0,0,$mo,$da,$yr+1)).'">&raquo;</a></td>');
echo('</tr>'."\n");
echo('<tr>');
echo('<td colspan="1" align="center" class="linkbar2"><a href="?day='.date('Y-m-d', mktime(0,0,0,$mo,0,$yr)).'">&laquo;</a></td>');
echo('<td colspan="5" align="center" class="linkbar2"><p class="calendar">'.date('F', mktime(0,0,0,$mo,$da,$yr)).'</p></td>');
echo('<td colspan="1" align="center" class="linkbar2"><a href="?day='.date('Y-m-d', mktime(0,0,0,$mo+1,1,$yr)).'">&raquo;</a></td>');
echo('</tr>'."\n");
$cntr = 1; // day printing counter
for ($i=1;$i<=6;$i++) {
  echo('<tr>');
  for ($j=1;$j<=7;$j++) {
    $curr = $cntr++;
    if ($days[$curr]['dat'] == $yr.'-'.$mo.'-'.$da) $style = 'bold'; else $style = 'normal';
    echo('<td width="14%" style="font-weight: '.$style.'">'.$days[$curr]['out'].'</td>'."\n");
  }
  echo('</tr>'."\n");
}
echo('</table>');
?>

</body>

</html>
*/
?>