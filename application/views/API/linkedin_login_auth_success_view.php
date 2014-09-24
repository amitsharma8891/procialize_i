<?php
    session_start();
    require_once(APPPATH.'libraries/linkedin/oAuth/config.php');
    require_once(APPPATH.'libraries/linkedin/oAuth/linkedinoAuth.php');
    require_once(APPPATH.'libraries/linkedin/oAuth/class.linkedClass.php');
    
    
    $linkedClass   =   new linkedClass();
    # First step is to initialize with your consumer key and secret. We'll use an out-of-band oauth_callback
    $linkedin = new LinkedIn($config['linkedin_access'], $config['linkedin_secret']);
    //$linkedin->debug = true;

   if (isset($_REQUEST['oauth_verifier'])){
        $_SESSION['oauth_verifier']     = $_REQUEST['oauth_verifier'];

        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->getAccessToken($_REQUEST['oauth_verifier']);
        $_SESSION['oauth_access_token'] = serialize($linkedin->access_token);
   }
   else{
        $linkedin->request_token    =   unserialize($_SESSION['requestToken']);
        $linkedin->oauth_verifier   =   $_SESSION['oauth_verifier'];
        $linkedin->access_token     =   unserialize($_SESSION['oauth_access_token']);
   }
   $content1 = $linkedClass->linkedinGetUserInfo($_SESSION['requestToken'], $_SESSION['oauth_verifier'], $_SESSION['oauth_access_token']);
   echo '<pre>';print_r($content1);echo '</pre>';
   
    $xml   = simplexml_load_string($content1);
    $array = XML2Array($xml);
    $content = array($xml->getName() => $array);
    
    include(APPPATH.'libraries/linkedin/include.php');
    exit;
    
    function XML2Array(SimpleXMLElement $parent)
    {
        $array = array();
        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
                && (1 === count($node) ? $node = array($node) : 1)
                && $node = & $node[];
            $node = $element->count() ? XML2Array($element) : trim($element);
        }
        return $array;
    }
?>