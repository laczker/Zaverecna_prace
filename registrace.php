<?php
session_start();

require 'db.php';

if (!empty($_POST)) {

    $email = @$_POST['email'];
    $heslo = @$_POST['heslo'];

    $passwordHash = password_hash($heslo, PASSWORD_DEFAULT);

    $stmt = $db->prepare("INSERT INTO uzivatel(email, heslo) VALUES (?, ?)");
    $stmt->execute([$email, $passwordHash]);


    $stmt = $db->prepare("SELECT uzivatel_id FROM uzivatel WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $_SESSION['uzivatel_id'] = (int)$stmt->fetchColumn();

    //přesměrujeme uživatele na homepage
    header('Location: index.php');
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<h1>PHP Shopping App</h1>

<h2>New Signup</h2>

<form method="post">
    <label for="email">Your Email</label><br/>
    <input type="text" name="email" id="email" required value="<?php echo htmlspecialchars(@$_POST['email']);?>"><br/><br/>

    <label for="password">New Password</label><br/>
    <input type="password" name="password" id="password" required value=""><br/><br/>

    <input type="submit" value="Create Account"> or <a href="index.php">Cancel</a>
</form>

</body>
</html>