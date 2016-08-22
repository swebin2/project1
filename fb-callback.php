<?php
session_start();
require_once "includes/includepath.php";
require_once( 'Facebook/autoload.php');

  $fb = new Facebook\Facebook([
	  'app_id' => '666041090229631', // Replace {app-id} with your app id
	  'app_secret' => '2a00fb5635334f4ab004f1a6217ced5f',
	  'default_graph_version' => 'v2.5',
	  ]);
$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
   $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}


if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('666041090229631'); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }
  
  //echo '<h3>Long-lived</h3>';
//  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

//print_r($_SESSION['fb_access_token']);

$fbuser = $response->getGraphUser();

//echo $_SESSION['curr_url'];

//print_r($fbuser);

//echo "ID: ".$fbuser['id']."<br>";
//echo "Full Name: ".$fbuser['name']."<br>";
//echo "First Name: ".$fbuser['first_name']."<br>";
//echo "Last Name: ".$fbuser['last_name']."<br>";
//echo "Email: ".$fbuser['email'];


// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');
require_once "includes/config.php";
require_once "classes/general.class.php";

$objgen		=	new general();

$email  	    = $fbuser['email'];
$full_name  	= $fbuser['name'];
$facebook_id  	= $fbuser['id'];


$sh_exit = $objgen->chk_Ext("users","facebook_id='$facebook_id'");
if($sh_exit>0)
{
  $result = $objgen->get_Onerow("users","AND facebook_id='".$facebook_id."'");
  
  if($result['email']!="" && $result['mobile']!="")
  {
  
	  $_SESSION['ma_log_id']		=  $result['id'];
	  $_SESSION['ma_usr_name']	    =  $result['email'];
	  $_SESSION['ma_name']	        =  $result['full_name'];
	  
	  if($result['otp_verify']=="no")
	  {
		header("location:".URL."verify-otp");  
	  }
	  else
	  {
	  
	   header("location:".URLUR);
	   
	  }
  
  }
  else
  {
	   $_SESSION['ma_log_id']		=  $result['id'];
	  $_SESSION['ma_usr_name']	    =  $email;
	   if($email="")
		 $_SESSION['ma_usr_name']	    =  "Null";
					
	   $_SESSION['ma_name']	        =  $full_name;
	   header("location:".URL."user-signup");
  }

}
else
{
	if($email!="")
	{
		$sh_exit2 = $objgen->chk_Ext("users","email='$email'");
		if($sh_exit2>0)
		{
			 $email = "";
		}
	}
	
	 $status  		= "inactive";
	 $msg = $objgen->ins_Row('users','email,status,full_name,facebook_id',"'".$email."','".$status."','".$full_name."','".$facebook_id."'");
	 
	  $my_id = $objgen->get_insetId();
	 
	  $_SESSION['ma_log_id'] = $my_id;
	  header("location:".URL."user-signup");
	 
}

?>