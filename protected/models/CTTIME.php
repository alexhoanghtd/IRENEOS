<?php

class CTTime {

    public static function toTime($dateTime) {
        $dateTime = explode(" ", $dateTime);
        //print_r($dateTime);
        $date = $dateTime[0];
        $detail = explode('-', $date);
        return $detail[2]." ".self::getShortMonth($detail[1])." ".$detail[0];
    }

    public static function getShortMonth($month) {
        if (is_int((int)$month)) {
            switch ($month){
                case 1:
                    return "Jan";
                case 2:
                    return "Feb";
                case 3:
                    return "Mar";
                case 4:
                    return "Apr";
                case 5:
                    return "May";
                case 6:
                    return "Jun";
                case 7:
                    return "Jul";
                case 8:
                    return "Aug";
                case 9:
                    return "Jan";
                case 10:
                    return "Oct";
                case 11:
                    return "Nov";
                case 12:
                    return "Dec";
            }
        } else {
            
            echo 'not a valid input';
            return false;
        }
    }

}
