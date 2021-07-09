<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login with Facebook using PHP and MySQL</title>
<link href="css/bootstrap.css" type="text/css" rel="stylesheet">
 
</head>

<?php include('config.php'); ?>
<?php include('oauth-user.php'); ?>


<body>

	<div class="container">
		
		<div class="row" style="margin-top: 50px;">
			<div class="col-md-4"></div>
			<div class="col-md-4">

                <h2>Login to your account</h2>
                <hr/>
				<form class="form-vertical" action="" method="POST">
					
					<div class="form-group">
						<label>Email Address</label>
						<input type="email" name="email_address" class="form-control" required placeholder="Enter your email address" value="<?php if(isset($_COOKIE['email_cookie'])){ echo $_COOKIE['email_cookie'] ; } ?>">
					</div>

					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" required placeholder="Enter your password"  value="<?php if(isset($_COOKIE['pass_cookie'])){ echo $_COOKIE['pass_cookie'] ; } ?>" >
					</div>

					<div class="form-group">
						<input type="checkbox" name="remember" value="Yes">
						Remember Me
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success" name="LoginButton">
							Login
						</button>
						 
					</div>

				</form>    
				
				 
                <hr/>

		<?php
		
		if(isset($accessToken)) {
			if(isset($_SESSION['facebook_access_token'])){
				$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
			} else {
				
				$_SESSION['facebook_access_token'] = (string) $accessToken;
				
				$oAuth2Client = $fb->getOAuth2Client();
				
				if(!$accessToken->isLongLived()) {
					try {
						$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
						$_SESSION['facebook_access_token'] = (string) $accessToken;
					} catch (Facebook\Exceptions\FacebookSDKException $e) {
						echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
						exit;
					}
				}			
			}
			
			if(isset($_GET['code'])){
				header('Location: ./');
			}
			
			
			try {
				$profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
				$fbUserData = $profileRequest->getGraphNode()->asArray();
				
				$oauth_user_obj = new OauthUser();
				$userData = $oauth_user_obj->verifyUser($fbUserData);
			} catch(FacebookResponseException $e) {
				echo 'Graph returned an error: ' . $e->getMessage();
				session_destroy();
				header("Location: ./");
				exit;
			} catch(FacebookSDKException $e) {
				echo 'Facebook SDK returned an error: ' . $e->getMessage();
				session_destroy();
				header("Location: ./");
				exit;
			}
		
		
			 // $logoutURL = $helper->getLogoutUrl($accessToken, FB_REDIRECT_URL.'logout.php');
			
		
			
		} else {
					$loginUrl = $helper->getLoginUrl($redirectUrl);
			echo '<a href="'.htmlspecialchars($loginUrl).'"><img class="login_image" src="fblogin-btn.png"></a>';
		}
	?>
	   
	        </div>
        </div>

    </div>
</body>
</html>