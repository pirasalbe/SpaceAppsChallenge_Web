<?php


$query_string = "?r=new_report&";
$query_string .= $_SERVER['QUERY_STRING'];

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => 'http://10.0.3.17' . $query_string,
    CURLOPT_USERAGENT => 'New Report'
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
echo $resp;
curl_close($curl);
