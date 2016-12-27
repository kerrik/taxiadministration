<?php

function tur_cal_print_days_in_month(){
    $num = cal_days_in_month(CAL_GREGORIAN, 8, 2003);
    for ($counter1=1;$counter1<=$num;$counter1++){
        echo nl2br( "<div class='date'>". $counter1."</div>\n");
    }//end for
} //end tur_cal_print_days_in_month
?>
