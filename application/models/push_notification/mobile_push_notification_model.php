<?php

class mobile_push_notification_model extends CI_Model {

    function __construct() {
// Initialization of class
        parent::__construct();
       
    }
    
    function send_notification($registration_id,$mobile_os,$message)
    {
        if($mobile_os == 'android')
		{
			return $this->push_gcm($registration_id,$message);
		}
		elseif($mobile_os == 'ios')
		{
			return $this->push_aspn($registration_id,$message);
		}
    }
	
	function push_gcm($registration_id,$message)
	{
		if(!$registration_id || !$message)
        {
            //echo '16*****'.$registration_id.'<br>';
            //echo '17^^^^^^*****'.$message.'<br>';
            return FALSE;
        }
            
        $headers = array(
            'Authorization: key='. GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => array($registration_id),
            'data' => array('message' => $message, 'tickerText' => 'ticker', 'contentTitle' => 'title', "contentText" => 'context'),
        );
        
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        //echo $result;
        return $result;
    //}
	}
	
	function push_aspn($deviceToken,$message)
	{
		//echo '---->'.$deviceToken;
		// Put your private key's passphrase here:
		$passphrase = 'password';

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);

		//echo 'Connected to APNS' . PHP_EOL;

		// Create the payload body
		$body['aps'] = array(
			'alert' => $message,
			'sound' => 'default'
			);

		// Encode the payload as JSON
		$payload = json_encode($body);

		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));

		/*if (!$result)
			echo 'Message not delivered' . PHP_EOL;
		else
			echo 'Message successfully delivered' . PHP_EOL;*/

		// Close the connection to the server
		fclose($fp);
	}
	
   
    
    
}

?>
