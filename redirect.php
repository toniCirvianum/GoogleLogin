<?php

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/credentials.php";

$client = new Google\Client;

$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);

if (!isset($_GET["code"])) {
    $client->addScope("email");
    $client->addScope("profile");
    $url = $client->createAuthUrl();
    // header("Location: " . $url);
    header("Refresh: 0 ; URL=" . $url);
    echo "<h1>Redirecting to Google</h1>";
    echo "<p>If you are not redirected, please <a href='$url'>click here</a></p>";
    exit();
} else {
    echo "<h1>Successfully authenticated</h1>";
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

    $client->setAccessToken($token["access_token"]);

    $oauth = new Google\Service\Oauth2($client);

    $userinfo = $oauth->userinfo->get();

    foreach ($userinfo as $key => $value) {
        echo "<p>";
        echo $key . "=" . $value;
        echo "</p>";
    }
}
