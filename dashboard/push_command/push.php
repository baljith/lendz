<?php

$deviceToken = $_REQUEST['token'];

$message = $_REQUEST['message'];

$type = $_REQUEST['type'];

unset($_REQUEST['token']);
unset($_REQUEST['message']);
unset($_REQUEST['type']);
$passphrase = '123456789';

$ctx = stream_context_create();
//stream_context_set_option($ctx, 'ssl', 'local_cert', 'cert.pem');
stream_context_set_option($ctx, 'ssl', 'local_cert', 'ToolTruck.pem');
stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);


if (!$fp)
	exit("Failed to connect: $err $errstr" . PHP_EOL);

echo 'Connected to APNS' . PHP_EOL;

$body['aps'] 			=  $_REQUEST;

$body['aps']['alert'] 	= array(
		'body' => $message,
		'type' => $type,
		'action-loc-key' => 'ToolTruck',
		);
$body['aps']['sound'] = 'oven.caf';

$payload = json_encode($body);

	
$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

$result = fwrite($fp, $msg, strlen($msg));

if (!$result)
	echo 'Message not delivered' . PHP_EOL;
else
	echo 'Message successfully delivered' . PHP_EOL;

fclose($fp);