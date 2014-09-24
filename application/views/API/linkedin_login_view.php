<?php 
    session_start();
    include_once APPPATH.'libraries/linkedin/oAuth/config.php';
    include_once APPPATH.'libraries/linkedin/oAuth/linkedinoAuth.php';
    
    //include_once 'oAuth/config.php';
//    /include_once 'oAuth/linkedinoAuth.php';
    
//    echo date('l jS \of F Y h:i:s A',"1352203709");
    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret'], $config['base_url'] . 'API/event_api_call/linkedin_auth_success' );
//    $linkedin->debug = true;

    # Now we retrieve a request token. It will be set as $linkedin->request_token
    $linkedin->getRequestToken();
    $_SESSION['requestToken'] = serialize($linkedin->request_token);
  
    # With a request token in hand, we can generate an authorization URL, which we'll direct the user to
   ## echo "Authorization URL: " . $linkedin->generateAuthorizeUrl() . "\n\n";
    header("Location: " . $linkedin->generateAuthorizeUrl());

?>