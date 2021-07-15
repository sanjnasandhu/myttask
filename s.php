<?php


session_start();

$CLIENT_ID = "149747733911575";
$CLIENT_SECRET = "7b0d10874a3ab08f6011a97fd2cf4cf5";
$CALLBACK = "http://localhost/facebookAPI/s.php";
$SCOPES = array("email");

function authorizeUrl($client_id, $callback, $scopes = array())
{
  $pattern = "https://graph.facebook.com/oauth/authorize?client_id=%s&redirect_uri=%s&scope=%s&response_type=code";

  return sprintf($pattern, $client_id,
                           urlencode($callback),
                           implode("+", $scopes));
}

function getAccessCode($client_id, $callback, $client_secret, $request_code) {
  $curl = curl_init("https://graph.facebook.com/oauth/access_token");
 

  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
  curl_setopt($curl, CURLOPT_HEADER, false);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, rawurldecode(http_build_query(array(
    'client_id' => $client_id,
    'redirect_uri' => $callback,
    'client_secret' => $client_secret,
    'code' => $request_code,
    'grant_type' => 'authorization_code'
  ))));

  $json = json_decode(curl_exec($curl));

   
  return $json->access_token;
}

function getAdministrations($access_token) {
  $headers = array(
    'Accept: application/json',
    sprintf('Authorization: Bearer %s', $access_token)
  );


  $curl = curl_init("https://graph.facebook.com/v11.0/me?fields=id,name,email&access_token");
  
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  $result = json_decode(curl_exec($curl));

    return $result;
}

if (isset($_GET['error'])) {
  session_destroy();
  header(sprintf("Location: %s", $CALLBACK));
  die();
} elseif(isset($_SESSION['access_token'])) {
  $administrations = getAdministrations($_SESSION['access_token']);

if(isset($administrations->error)){
    session_destroy();
    header(sprintf("Location: %s", $CALLBACK));
    die();
  }else{
    
   // echo 'id:' .$administrations->id ."<br/>";
   //  echo 'name:' .$administrations->name ."<br/>";
   //   echo 'email:' .$administrations->email ."<br/>";
   //  die();
    include("myinfo.php");
  }
  // foreach($administrations as $administration) {
  // echo $administration->name . "<br />";

  // }
} if (isset($_GET['code'])) {
  $access_token = getAccessCode($CLIENT_ID, $CALLBACK, $CLIENT_SECRET, $_GET['code']);
 
  $_SESSION['access_token'] = $access_token;

  header(sprintf("Location: %s", $CALLBACK));
  die();
} 