<?php

function get_all_reports()
{
    $query_string = "?r=all_reports";
    $query_string .= $_SERVER['QUERY_STRING'];

// Get cURL resource
    $curl = curl_init();
// Set some options - we are passing in a useragent too here

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://10.0.3.17' . $query_string,
        CURLOPT_USERAGENT => 'All Reports'
    ));
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
     curl_close($curl);


    //$json = json_decode("[\"{\"id\":6,\"locationX\":45.543998718261719,\"locationY\":11.554200172424316}","{\"id\":7,\"locationX\":45.543998718261719,\"locationY\":11.554200172424316}\"]", true);

    $json = json_decode($resp, true);


    return $json;

}