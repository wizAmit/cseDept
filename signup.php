<?php
	//set_include_path(get_include_path(). PATH_SEPARATOR . './resources/library/google-modified-api/src/');
	require_once 'resources\library\google-modified-api\src\Google_Client.php';
	require_once 'resources\library\google-modified-api\src\contrib\Google_Oauth2Service.php';
	require_once 'resources\config.php';	
	
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) 
		ob_start("ob_gzhandler"); 
	else 
		ob_start();

	//start session
	session_start();

	//sessionkey to identify google token
	$token_key = 'google_user_token';

	$client = new Google_Client();
  	$client->setApplicationName(APP_NAME);
  	$client->setDeveloperKey($developerCreds['Google_localhost']['developer_key']);
	$client->setClientId($developerCreds['Google_localhost']['client_id']);
	$client->setClientSecret($developerCreds['Google_localhost']['client_secret']);
	$client->setRedirectUri($developerCreds['Google_localhost']['redirect_uris']);
	$client->setScopes(array('https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
	$google_redirect_url = $developerCreds['Google_localhost']['redirect_uris'];

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

		header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

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
	include './header-includes.php';
	include './header.php';
?>
		<div class="container" style="margin-top: 2%;">
		<?php if($auth_url) : ?>
		<div class="form-signin" style="position:fixed; top:7px; right:5px;">	
				<input type="number" min="11500110000" step="1" id="UnivRoll" name="UniversityRollNo" pattern="\d{10,11}" 
			   		title="Your 11 digit University Roll Number" placeholder="University Roll Number" maxlength="11" required
					class="form-control" style="width:250px;" onkeyup="validate()">
				<label id="name" style="display:none;" ondblclick="reset()"></label>
				<a href="<?php echo $auth_url; ?>" id="gsignin" style="display:none;">
					<img src="./img/google-login-button.png" alt="Sign-in with Google!!">
				</a>
		</div>
		<?php else : ?>
			<!--<div>
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
			</div>-->
			<div id="gplusPic" style="position: fixed; top: 50px; right: 50px;">
				<img src="<?php echo $profile_image_url; ?>?sz=150" alt="Image" class="img-thumbnail" />
			</div>
				<?php include './options.php'; ?>
			<?php endif; ?>
			</div>
		<script>
			var univRoll = $("#UnivRoll");
			
			var validate = function() {
				var roll = $("#UnivRoll").val();
				if (roll != ''){
					if (roll.match(/\d{10,11}/)) {
						$.post("./chkRoll.php", 
				   			{"univRoll" : roll }, 
				   function(data){
							if (data.length>0){
								$("#UnivRoll").fadeOut("slow");
								$("#name").fadeIn("slow");
								$("#name").html(data);
								$("#gsignin").fadeIn("slow");
								setcookie();
							}
				   		});
					}
					else
						$("#gsignin").hide();
				}
			}
			var reset = function(){
				$("#name").fadeOut("slow");
				$("#gsignin").fadeOut("slow");
				$("#UnivRoll").fadeIn("slow");
				$("#UnivRoll").val() = '';
			}
			function setCookie() {	
				document.cookie = "univRoll=" + univRoll.value;
			}
		</script>
<?php
	include "./footer.php";
?>
