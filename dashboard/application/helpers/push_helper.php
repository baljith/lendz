<?php
function sendPush($data,$msg,$player_id)
{   
    $content = array(
            "en" => $msg
            );
    $fields = array(
        'app_id' => "baecf2bd-0a2b-42eb-915a-6b73d71f7a14",
        'include_player_ids' => array($player_id),
        'contents' => $content,
        'data' => $data
    );
   

    $fields = json_encode($fields);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Authorization: Basic AAAAI7ckHOo:APA91bHfH4EDgZaaQmFmSzQ5YGQckDbrROkyt_jYwRKEyDryO3QQKCT6vLODUMc1tbz9mJ56r4S4KYaCz8FcmlVq2WQpqRU1c9FYPHFM2FsyinKdNsiHkTXJhRGzqxKDc_1jX3MmkvZW'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $response = curl_exec($ch);
    // echo '<pre>';
    // print_r($response);die();
    curl_close($ch);        
}

