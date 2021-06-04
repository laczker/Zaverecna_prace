<?php

session_start();

require 'db.php';
require_once __DIR__ . "/vendor/autoload.php";
$clientID = '131062190477-7n95rips3hpuro8nj4otggkdluqobo8r.apps.googleusercontent.com';
$clientSecret = '13zGWs8ctd3nVe2PnvIVbHfJ';
$redirectUri = 'http://localhost/Zaverecna_prace/prihlaseni.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");



if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // get profile info
    $google_oauth = new Google_Service_Oauth2($client);
    $google_account_info = $google_oauth->userinfo->get();
    $email =  $google_account_info->email;
    $name =  $google_account_info->name;

    $stmt = $db->prepare("SELECT * FROM uzivatel WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);

    if (($existingUser = $stmt->fetch(PDO::FETCH_ASSOC))) {
        $_SESSION['uzivatel_id'] = $existingUser['uzivatel_id'];
        header('Location: index.php');
    } else {
        $stmt = $db->prepare("INSERT INTO uzivatel (email, heslo, role) VALUES (?, ?, ?)");
        $stmt->bindValue(1, $email);
        $stmt->bindValue(2, "nemá heslo");
        $stmt->bindValue(3, "user");
        $stmt->execute();

        $stmt = $db->prepare("SELECT * FROM uzivatel WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['uzivatel_id'] = $existingUser['uzivatel_id'];
        header('Location: index.php');
    }


    // now you can use this profile info to create account in your website and make user logged in.
}

if (!empty($_POST)) {
    $email = @$_POST['email'];
    $heslo = @$_POST['heslo'];

    $stmt = $db->prepare("SELECT * FROM uzivatel WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);

    if (($existingUser = $stmt->fetch(PDO::FETCH_ASSOC)) && password_verify($heslo, @$existingUser['heslo'])) {
        $_SESSION['uzivatel_id'] = $existingUser['uzivatel_id'];
        header('Location: index.php');
    } else {
        $formError = "Invalid user or password!";
    }
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

    <h1>PHP Shopping App</h1>

    <h2>Sign in</h2>

    <?php
    if (!empty($formError)) {
        echo '<p style="color:red;">' . $formError . '</p>';
    }
    ?>

    <form method="post">
        <label for="email">Váš email</label><br />
        <input type="text" name="email" id="email" value="<?php echo htmlspecialchars(@$_POST['email']) ?>"><br /><br />

        <label for="heslo">heslo</label><br />
        <input type="password" name="heslo" id="heslo" value=""><br /><br />

        <input type="submit" value="Sign in">
    </form>

    <br />


    <a href='<?= $client->createAuthUrl() ?>'>Google Login</a>;

    <a href="registrace.php">Registrovat se</a>

</body>

</html>