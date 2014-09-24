<?php

class gcm extends CI_Controller {

    /**
     * Index Class
     *
     * @package	Procialize 
     * @subpackage	gcm controller
     * @author		Amit  sharma
     * @copyright	Copyright (c) 2014 - 2015 
     * @since		Version 1.0
     */
    function __construct() {
        parent::__construct();
        $this->load->model('API/client_login_api_model','model');
    }

    
    function gcm_view()
    {
        $this->load->view('API/gcm/gcm_view');
    }
    
    function register_gcm()
    {
        $api_access_token = $this->input->post('api_access_token');
        $gcm_regid = $this->input->post('registration_id');
        $mobile_os = $this->input->post('mobile_os');
        
        $user_data                                                              = check_access_token($api_access_token,$check_null = TRUE);
        //display($user_data);
        $user_id                                                                = $user_data->user_id;
        $json_array['error']                                                    = 'error';
        $json_array['msg']                                                      = 'Something went wrong';
        if(!$user_id || !$gcm_regid)
        {
            json_output($json_array);
            return FALSE;
        }
            
        $table_array = array(
                                'gcm_reg_id'=> $gcm_regid,
                                'modified_date' => date('Y-m-d H:i:s'),
                                'mobile_os'     => $mobile_os
                            );
        
        $this->db->where('id',$user_id);
        $this->db->update('user',$table_array);
        $json_array['error']                                                    = 'success';
        $json_array['msg']                                                      = 'success';
        
        json_output($json_array);
    }
    
    function send_notification()
    {
        echo 'test'.GOOGLE_API_KEY.'<br>';
        $registration_id = $this->input->post('registration_id');
        $message = $this->input->post('message');
        //$registration_id = 'APA91bG5bCjed4vBqm66r6a4S4W0DKBmj5JafdQjvKiNs9-LGoDaND6Z0JG93B0mTgOVySGYPkcjKu8W72q-OLr5hOL3xxdmYbbV9X0dHaP6IpqEfWotpowq0ifkGLLSl-Y7KA7lXTRsCpLLzeqtsbOovRAsHuh-54kJqthUwUnL_nrGuW8i_Dg';
        echo $registration_id = 'APA91bG86skFrEoKjCu0tkVg4WW5Tlp5p-hAYd4SIysybJLYcLSXa0PBhBKxUFeDq2SOw_YVyUQ2eppIqdqK45eaPeIDXdcYh5S6uKMb5YP1yw_iuwZt1dDlslqhaUcyEc_X1jlB1eaFH7htQE1gmE51kcSJoZ-1qHjzOzwoGqvW-1YSCfangi0';
        $message = array('test');
        //if(!$registration_id || !$message)
          //  return FALSE;
        
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => array($registration_id),
            'data' => array('message' => $message, 'tickerText' => 'ticker', 'contentTitle' => 'title', "contentText" => 'context'),
        );
 
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
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
        echo $result;
    //}
    }
	
	function aspn()
	{
		// Put your device token here (without spaces):
		//$deviceToken = 'c9d47f49f3d0ec81c3065a2b07b6ce9e1486a45cede6de51cb5b090e5b796f25';
		$deviceToken = '809d1cd7cd8e454fb045fbd2fe3eb958c3da424d4f71b434102a40d65b77d3c0';

		// Put your private key's passphrase here:
		$passphrase = 'password';

		// Put your alert message here:
		$message = 'My first push notification from Procialize!';

		////////////////////////////////////////////////////////////////////////////////

		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'ck.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);

		echo 'Connected to APNS' . PHP_EOL;

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

		if (!$result)
			echo 'Message not delivered' . PHP_EOL;
		else
			echo 'Message successfully delivered' . PHP_EOL;

		// Close the connection to the server
		fclose($fp);
	}
}