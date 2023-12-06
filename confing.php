<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('496169888684-ucc12hs0bc97hhncoaip2s5dp15e1kr8.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/proyecto/ex.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');

?> 