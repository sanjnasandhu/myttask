<?php
if(!session_id()){
    session_start();
}

// Include the Facebook SDK
require_once __DIR__ . '/Facebook/autoload.php';

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/**
 * Configuration & setup Facebook API SDK
 **/
$appID        = '174709377970010'; //Facebook App ID
$appSecretKey     = '1ce661f8ec2119cd55471a36be877cc8'; //Facebook App Secret Key
$redirectURL   = 'http://localhost/facebook1/post/'; //Callback URL
$fbPermissions = array('publish_actions'); 
$fb = new Facebook(array(
    'app_id' => $appID,
    'app_secret' => $appSecretKey,
    'default_graph_version' => 'v2.6',
));


$helper = $fb->getRedirectLoginHelper();


try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}
?>