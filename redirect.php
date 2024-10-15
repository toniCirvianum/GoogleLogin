<?php
//carreguem les llibreries de google i el fitxer de credencials
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/credentials.php";

$client = new Google\Client;
//inicialitzem el client amb les dades de credencials
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);

//si no tenim el codi de l'autorització, redirigim a google
if (!isset($_GET["code"])) {
    $client->addScope("email");
    $client->addScope("profile");
    $url = $client->createAuthUrl();
    // header("Location: " . $url);
    header("Refresh: 0 ; URL=" . $url);
    exit();
} else {
    //si tenim el codi de l'autorització, l'intercanviem per un token d'accés
    echo "<h1>Successfully authenticated</h1>";
    $token = $client->fetchAccessTokenWithAuthCode($_GET["code"]);

    $client->setAccessToken($token["access_token"]);

    $oauth = new Google\Service\Oauth2($client);

    $userinfo = $oauth->userinfo->get();
    //mostrem les dades de l'usuari
    foreach ($userinfo as $key => $value) {
        echo "<p>";
        echo $key . "=" . $value;
        echo "</p>";
    }
}
