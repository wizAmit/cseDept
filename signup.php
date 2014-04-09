<?php 
	require_once ( 'Google_Client.php');
	require_once ( '\contrib\Google_Oauth2Service.php');
	require_once ( '.\resources\config.php');	
	
	
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) 
		ob_start("ob_gzhandler"); 
	else 
		ob_start();

	//start session
	session_start();

	//sessionkey to identify google token
	$token_key = 'google_user_token';

	echo (APP_NAME . "\n");
	$client = new Google_Client();
  	$client->setApplicationName(APP_NAME);
  	$client->setDeveloperKey($developerCreds['Google_localhost']['developer_key']);
	$client->setClientId($developerCreds['Google_localhost']['client_id']);
	$client->setClientSecret($developerCreds['Google_localhost']['client_secret']);
	$client->setRedirectUri($developerCreds['Google_localhost']['redirect_uris']);
	$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));

	// if request is to logout then do it and redirect
	if (isset($_REQUEST['logout']))
	{
		$client->revokeToken($_SESSION[$token_key]);

		unset($_SESSION[$token_key]);

		header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

		exit;
	}

	// if URL has a code then set it in the session and redirect
	if (isset($_GET['code']))
	{
		$client->authenticate();

		$_SESSION[$token_key] = $client->getAccessToken();

		//header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

		exit;
	}

	// set google user token from the session if any
	if (isset($_SESSION[$token_key]))
	{
		$client->setAccessToken($_SESSION[$token_key]);
	}

	// get access token from google. If none returned then ask user to login
	if ($client->getAccessToken())
	{
		// get user details
		$oauth2Service = new Google_Oauth2Service($client);
		$user = $oauth2Service->userinfo->get();

		$user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);

		$profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);

		$_SESSION[$token_key] = $client->getAccessToken();

		$auth_url = false;
	}
	else
	{
		$auth_url = $client->createAuthUrl();
	}
?>

<!DOCTYPE HTML>
<html lang="en">
	<head>
		<title>
			<?php if($auth_url) : ?>
			Sign Up
			<?php else : ?>
				Welcome <?php echo $user_name; 
				endif; ?>
		</title>
		<meta name="viewport" content="width=device-width">
		<script type="text/javascript" src="js/detailForm.js"></script>
		<link rel="stylesheet" type="text/css" href="./css/form.css" />
		<script type="text/javascript" src="resources/library/jquery-1.11.0.min.js"></script>
	</head>
	<body>
		<?php if($auth_url) : ?>
		<div>	
			<div>
				<input type="number" min="11500110000" step="1" id="UnivRoll" name="UniversityRollNo" pattern="\d{10,11}" 
			   		title="Your 11 digit University Roll Number" placeholder="University Roll Number" maxlength="11" required 
					   onblur="setCookie()" autofocus>
			</div>
			<div>
				<a class="login" href="<?php echo ($auth_url); ?>"><img src="img/google-login-button.png" alt="Sign in with Google" /></a>
			</div>
		</div>
		<?php else : ?>
			<div>
				<table>
					<tr>
						<td>
							<img src="<?php echo $profile_image_url; ?>?sz=150" alt="Image" />

							<br /><br />

							<a class="logout" href="?logout=1">Logout</a>
						</td>

						<td>
							<h3>Hi <?php echo $user_name; ?>!</h3>

							<pre><?php print_r($user); ?></pre>
							<pre><?php echo $_COOKIE['univRoll']; ?></pre>
						</td>
					</tr>
				</table>
			</div>
			<div id="subForms" >
				<div id="previous">
					<a href="">Previous</a>
				</div>
				<?php include ('PersonalDetails.php'); ?>
				<div id="next">
					<a href="">Next</a>
				</div>
			</div>
			<?php endif; ?>
		<script>
			function setCookie() {	
				var univRoll = $("#UnivRoll");
				document.cookie = "univRoll=" + univRoll.value + ";";
			}
		</script>
	</body>
</html>