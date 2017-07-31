<?php
ini_set('display_errors',0);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

/**
 * Copyright (c) 2014-present, Facebook, Inc. All rights reserved.
 *
 * You are hereby granted a non-exclusive, worldwide, royalty-free license to
 * use, copy, modify, and distribute this software in source code or binary
 * form for use in connection with the web services and APIs provided by
 * Facebook.
 *
 * As with any software that integrates with the Facebook platform, your use
 * of this software is subject to the Facebook Developer Principles and
 * Policies [http://developers.facebook.com/policy/]. This copyright notice
 * shall be included in all copies or substantial portions of the software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 */

require __DIR__ . '/vendor/autoload.php';



$access_token = 'Your Access Token'; 
$account_id = 'act_xxxxxxxxxx';
$app_secret = '***************';
$app_id="Your App ID";
 

date_default_timezone_set('America/Los_Angeles');
// Configurations - End

if(is_null($access_token) || is_null($app_id) || is_null($app_secret)) {
  throw new \Exception(
    'You must set your access token, app id and app secret before executing'
  );
}

if (is_null($account_id)) {
  throw new \Exception(
    'You must set your account id before executing');
}

use FacebookAds\Api;

Api::init($app_id, $app_secret, $access_token);

/**
 * Step 1 Read the AdAccount (optional)
 */
/* use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Fields\AdAccountFields;


$account = (new AdAccount($account_id))->read(array(
  AdAccountFields::ID,
  AdAccountFields::NAME,
  AdAccountFields::ACCOUNT_STATUS,
));

 echo "\nUsing this account: ";
echo $account->id."\n"; */
 
// Check the account is active
/* if($account->{AdAccountFields::ACCOUNT_STATUS} !== 1) {
  throw new \Exception(
    'This account is not active');
}
 */
/* echo "<pre>";

print_r($account);

echo "<pre>"; */

$fb = new Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => $app_secret,
  'default_graph_version' => 'v2.2',
  ]);

  

$helper = $fb->getRedirectLoginHelper();
 echo $accessToken = $helper->getAccessToken();
 
 
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name',$access_token);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$user = $response->getGraphUser();

//echo 'Name: ' . $user['name'];
// OR
// echo 'Name: ' . $user->getName();


$url="https://graph.facebook.com/v2.9/me?fields=id,name,adaccounts{account_id,ads{adset,campaign,name,bid_amount,campaign_id,leads{ad_name,campaign_name,adset_name},adlabels,insights{account_name,campaign_id,campaign_name,ad_name,adset_name,impressions,clicks,spend,cost_per_total_action,date_start,date_stop}},amount_spent,agency_client_declaration,business_name,name,business}&access_token=$access_token";
//  Initiate curl
$ch = curl_init();

$header= array("content-type: application/json");
curl_setopt($ch,  CURLOPT_HTTPHEADER, $header);


// Disable SSL verification
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// Will return the response, if false it print the response

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
// Set the url
curl_setopt($ch, CURLOPT_URL,$url);
// Execute
$result=curl_exec($ch);
// Closing
curl_close($ch);

/* echo "<pre>";
print_r(json_decode($result));
echo "</pre>"; */
// Will dump a beauty json :3
//var_dump(json_decode($result, true));

$fb_campaigns =json_decode($result, true);
$fb_campaigns = $fb_campaigns['adaccounts']['data'];

foreach($fb_campaigns as $res){


foreach($res['ads'] as $res1){	
	
	 foreach($res1 as $insights){
		 	
	  foreach(@$insights['insights']['data'] as $insight){
	
		 /* 
			  	   echo "<pre>";
print_r($insight );
echo "</pre>";  */
		/*   echo "<pre>";
print_r($insightval );
echo "</pre>";  */

	  $insight_data[]= $insight;
		  
}
}
}

}

/* echo "<pre>";
print_r($insight_data);
echo "</pre>";
 */



?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Campaign</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="css/styles.css?v=1.0">

 
  <style>
  /* Temp styles */
.header, .sidebar, .content, .footer { border: 5px solid black; }
.content, .sidebar, .footer { border-top: none; }
.sidebar.right { border-right: none; }
.sidebar.left { border-left: none; }
/* Core styles */
.header {
    position: relative; /* needed for stacking */
    height: 100px;
    width: 100%;
}
.content {
    position: relative; /* needed for stacking */
    width: 100%;
    height: 500px;
}
.sidebar {
    position: relative; /* needed for stacking */
    width: 20%;
    height: 100%;
    border-top: none;
}
.sidebar.left { float: left; }
.sidebar.left:after,
.sidebar.right:after {
    clear: both;
    content: "\0020";
    display: block;
    overflow: hidden;
}
.sidebar.right { float: right; }
.footer {
    position: relative; /* needed for stacking */
    width: 100%;
    height: 100px;
}
  </style>
</head>

<body>
 
 
<div class="header">
    <div class="header-inner"><h4 align="center">Campaign Buddy <h4></div>       
</div>
<div class="content">
    
    <div class="content-inner"> 
	
	
<table border="1" bordercolor="#6699CC" style="width:100%" >
<tr>
<th bgcolor="#336699" style="color:#FFF">Campaign_id</th>
<th bgcolor="#336699" style="color:#FFF">Campaign Name</th>

<th bgcolor="#336699" style="color:#FFF">Ad Name</th>
<!--th bgcolor="#336699" style="color:#FFF">Status</th-->
<th bgcolor="#336699" style="color:#FFF">Impressions</th>
<th bgcolor="#336699" style="color:#FFF">Clicks</th>
<th bgcolor="#336699" style="color:#FFF">Spent</th>
<th bgcolor="#336699" style="color:#FFF">Start Date</th>
<th bgcolor="#336699" style="color:#FFF">Stop Date</th>
</tr>

<?PHP
foreach ($insight_data as $campaign) {
//---------------------------------
?>

<tr>
<td><?php echo $campaign['campaign_id']; ?></td>
<td><?php echo $campaign['campaign_name']; ?></td>
<td><?php echo $campaign['ad_name']; ?></td>
<!--td><?php //echo $campaign->campaign_group_status ?></td-->
<td><?php echo $campaign['impressions']; ?></td>
<td><?php echo $campaign['clicks']; ?></td>
<td><?php echo $campaign['spend']; ?></td>
<td><?php echo $campaign['date_start']; ?></td>
<td><?php echo $campaign['date_stop']; ?></td>



<?php } ?>
	
	</div>
   
</div>

</body>
</html>
