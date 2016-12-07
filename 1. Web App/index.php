<?php
$DEBUG = true; //if you want the last message written to a log file SensorLog.txt
$IOTHUB = false; //if Azure IoT Hub is used
$EVENTHUB = true; //if Azure Event Hub is used

//Azure Event Hub
$eh_token = '<insert your value here>SharedAccessSignature sr=...';
$eh_url = '<insert your value here>https://<name>.servicebus.windows.net/<name>/publishers/<pub name>/messages';

//Azure IoT Hub
$iot_token = "<insert your value here>SharedAccessSignature sr=...";
$iot_url = "<insert your value here>https://<name>.azure-devices.net/devices/<device>/messages/events?api-version=2016-02-03";

$line = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    if (count($_POST) == 0) {
        die("no data supplied");
    }
    $line = json_encode($_POST);
} 

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (count($_GET) == 0) {
        die("no data supplied");
    }
    $line = json_encode($_GET);
}
//EVENT HUB LOGIC STARTS HERE
if($EVENTHUB == true) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $eh_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $line,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        CURLOPT_HTTPHEADER => array(
        "authorization: ".$eh_token,
        "cache-control: no-cache"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if($err) {
        die($err);
    }
}
//EVENT HUB LOGIC STOPS HERE

//IOT HUB LOGIC STARTS HERE
if($IOTHUB == true) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $iot_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $line,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_HTTPAUTH => CURLAUTH_ANY,
        CURLOPT_HTTPHEADER => array(
        "authorization: ".$iot_token,
        "cache-control: no-cache"
        ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    
    if($err) {
        $myfile = fopen("SensorLog.txt", "w+") or die("Unable to open file!");
        fwrite($myfile,$err);
    	fclose($myfile);
        die($err);
    }
}
//IOT HUB LOGIC ENDS HERE

//DEBUG - OMIT THE LAST MESSAGE INTO A FILE
if ($DEBUG === true) {
    echo($response);
    echo("done");
    $myfile = fopen("SensorLog.txt", "w+") or die("Unable to open file!");
    fwrite($myfile,$line);
    fwrite($myfile,$response);
    fwrite($myfile,$err);
	fclose($myfile);
}
?>
