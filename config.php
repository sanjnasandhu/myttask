<?php
session_start();
require_once __DIR__ . '/Facebook/autoload.php';

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

$redirectUrl   = 'http://localhost/facebook1/'; 
$permissions = array('email'); 
$fb = new Facebook([
  'app_id' => '174709377970010', 
  'app_secret' => '1ce661f8ec2119cd55471a36be877cc8', 
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();
if (isset($_GET['state'])) {
    $helper->getPersistentDataHandler()->set('state', $_GET['state']);
}

try {
	if(isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
}catch(Facebook\Exceptions\FacebookResponseException $e) {

  echo 'Graph error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK error: ' . $e->getMessage();
  exit;
}

$helper = $fb->getRedirectLoginHelper();
$fbLogoutUrl = $helper->getLogoutUrl($_SESSION['fb_access_token'], "http://localhost/facebook1/index.php");
?>