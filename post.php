<?php
require_once 'fbconfig.php';
if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
        }
        else
        {
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
        $oAuth2Client = $fb->getOAuth2Client();

        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    $message = 'Test message Fb Api';
    $title = 'Post For Just Test';
    $url = '';
    $description = 'Just Testing';
    $img = '/var/www/html/facebook1/image/girl.jpg';
            
    $attachment = array(
        'message' => $message,
        'name' => $title,
        'link' => $url,
        'description' => $description,
        'picture'=>$img,
    );
    
    try{
        // Wall Post to Facebook
        $fb->post('/me/feed', $attachment, $accessToken);
        echo 'Post published successfully.';
    }catch(FacebookResponseException $e){
        echo 'Graph error: ' . $e->getMessage();
        exit;
    }catch(FacebookSDKException $e){
        echo 'Facebook SDK error: ' . $e->getMessage();
        exit;
    }
}else{
    // Facebook login URL
    $fbLoginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);
    // Redirect to Facebook login page
    echo '<a href="'.$fbLoginURL.'"><img src="fb-btn.png" style="margin: -6px; width:50px; height:25px;"><strong style="font-size:20px;">Post to Facebook Wall</strong></a>';
}
?>