<?php
// google api data
// goto https://console.developers.google.com to get one

$google_client_id = '730957649338.apps.googleusercontent.com';
$google_client_secret = 'YzOORzO4u41pVr7mTGu13Sc2';
$google_redirect_url = 'http://localhost/cseDept/Sandbox/signin/';
$google_developer_key = 'AIzaSyClgERWIYvWLqG228vLUldNugc3LKImpdA';

// required files
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_Oauth2Service.php';

// start session
session_start();

// session key to identify google token
$token_key = 'google_user_token';

// create instance of google client
$googleClient = new Google_Client();
$googleClient->setApplicationName('Sign in to CSE Dept');
$googleClient->setScopes(array('https://www.googleapis.com/auth/userinfo.profile', 'https://www.googleapis.com/auth/userinfo.email'));
$googleClient->setClientId($google_client_id);
$googleClient->setClientSecret($google_client_secret);
$googleClient->setRedirectUri($google_redirect_url);
$googleClient->setDeveloperKey($google_developer_key);

// if request is to logout then do it and redirect
if (isset($_REQUEST['logout']))
{
    $googleClient->revokeToken($_SESSION[$token_key]);

    unset($_SESSION[$token_key]);

    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

    exit;
}

// if URL has a code then set it in the session and redirect
if (isset($_GET['code']))
{
    $googleClient->authenticate();

    $_SESSION[$token_key] = $googleClient->getAccessToken();

    header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));

    exit;
}

// set google user token from the session if any
if (isset($_SESSION[$token_key]))
{
    $googleClient->setAccessToken($_SESSION[$token_key]);
}

// get access token from google. If none returned then ask user to login
if ($googleClient->getAccessToken())
{
    // get user details
    $oauth2Service = new Google_Oauth2Service($googleClient);
    $user = $oauth2Service->userinfo->get();

    $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);

    $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);

    $_SESSION[$token_key] = $googleClient->getAccessToken();

    $auth_url = false;
}
else
{
    $auth_url = $googleClient->createAuthUrl();
}
?>

<!DOCTYPE HTML>

<html>
    <head>
        <title>Sign in with Google</title>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <style type="text/css">
            table
            {
                padding: 0;
                margin: 0;
                border-collapse: collapse;
            }

            table td
            {
                padding: 5px;
                border: 1px solid #ccc;
                vertical-align: top;
            }
        </style>
    </head>

    <body>
        <?php if ($auth_url): ?>

            <a class="login" href="<?php echo $auth_url; ?>"><img src="images/google-login-button.png" alt="Sign in with Google" /></a>

        <?php else: ?>

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
                    </td>
                </tr>
            </table>

        <?php endif; ?>
    </body>
</html>
