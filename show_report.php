<?php

if(isset($_REQUEST["id"])) {
    $report_id = $_REQUEST["id"];
    $query_string = "?r=show_report?report_id=" . $report_id;

// Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://10.0.3.17' . $query_string,
        CURLOPT_USERAGENT => 'Show Report'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
    curl_close($curl);


    $json = json_decode($resp, true);
    //coordinate locationX/Y timestamp species_name damages solution



}