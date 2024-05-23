<?php
//formatting the date
/*takes a $timestamp variable that is the result of a SQL request of a timestamp SQL datatype
the result must be aliased as timestamp

EXEMPLE
    $query = "SELECT date AS timestamp FROM table";
    *prepare and execute the request*
    $timestamp = $request->fetchAll(PDO::FETCH_ASSOC);
    $timestamp = $timestamp[0]['timestamp'];
*/
if ($timestamp != NULL) {
    // $time = '2024-04-02 12:00:00' -> get date and time separatly
    $timestamp = explode(' ', $timestamp); // 
    $date = $timestamp[0]; //YYYY-MM-DD
    $time = $timestamp[1]; //HH:MM:SS
    //if last post is from today, display time, else display date
    //getting the present time
    date_default_timezone_set('UTC');
    $today = date("Y-m-d", time());
    if ($date == $today) {
        $time = explode(":", $time);
        $hour = $time[0];
        $minute = $time[1];
        $output = $hour . ':' . $minute;
    }   else {
        //get each individual date element
        $date = explode('-', $date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];
        //format the date to DD/MM/YYYY
        $output = $day . '/' . $month . '/' . $year;
    }
    
} else {
    $output = 'pas de date';
}
echo $output;