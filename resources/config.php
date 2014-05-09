<?php
 
/*
    The important thing to realize is that the config file should be included in every
    page of your project, or at least any page you want access to these settings.
    This allows you to confidently use these settings throughout a project because
    if something changes such as your database credentials, or a path to a specific resource,
    you'll only need to update it here.
*/
//require "./firephptest.php" ;
$config = array(
    "db" => array(
        "student_details" => array(
            "dbname" => "student_details",
            "username" => "root",
            "password" => "project",
            "host" => "localhost"
        ),
        "attendance" => array(
            "dbname" => "attendance",
            "username" => "root",
            "password" => "project",
            "host" => "localhost"
        ),
		"marks" => array(
            "dbname" => "marks",
            "username" => "root",
            "password" => "project",
            "host" => "localhost"
		)
    ),
    "urls" => array(
        "baseUrl" => "http://example.com",
		"errorUrl" => "../error.php"
    ),
    "paths" => array(
        "resources" => "/path/to/resources",
        "images" => array(
            "content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
            "layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
        )
    )
);
 
/*
    I will usually place the following in a bootstrap file or some type of environment
    setup file (code that is run at the start of every page request), but they work
    just as well in your config file if it's in php (some alternatives to php are xml or ini files).
*/
 
/*
    Creating constants for heavily used paths makes things a lot easier.
    ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined("LIBRARY_PATH")
    or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/library'));
     
defined("TEMPLATES_PATH")
    or define("TEMPLATES_PATH", realpath(dirname(__FILE__) . '/templates'));
 
/*
    Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);

/*
	Google Auth Credentials
*/

define("APP_NAME","CSE DEPT");
$developerCreds = array(
	"Google_localhost" => array(
		"developer_key" => "AIzaSyClgERWIYvWLqG228vLUldNugc3LKImpdA",
		"client_id" => "730957649338.apps.googleusercontent.com",
		"client_secret" => "YzOORzO4u41pVr7mTGu13Sc2",
		"redirect_uris" => "https://localhost/cseDept/signup.php",
		"api_key" => "AIzaSyClgERWIYvWLqG228vLUldNugc3LKImpdA"		
	),
	"Google_rhcloud" => array(
		"developer_key" => "AIzaSyClgERWIYvWLqG228vLUldNugc3LKImpdA",
		"client_id" => "730957649338-1nc6g79g20qcthp42hfgtslq17rv8dkb.apps.googleusercontent.com",
		"client_secret" => "v0A9SbFflARWkRUMfiXznfOO",
		"redirect_uris" => "https://csedept-wiz.rhcloud.com/Sandbox/signin/",
		"api_key" => "AIzaSyClgERWIYvWLqG228vLUldNugc3LKImpdA"
	),
	"StackExchange" => array(
		"client_id" => "mRh6PRRELThT*)IhZVWYNg((",
		"api_key" => "nGP18g6TMlYxhvFuCJTwiQ(("
	)
);
 
?>