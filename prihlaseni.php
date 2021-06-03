<?php

session_start();

require 'db.php';

if (!empty($_POST)){
    $email = @$_POST['email'];
    $heslo = @$_POST['heslo'];

    $stmt = $db->prepare("SELECT * FROM uzivatel WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);

    if (($existingUser=$stmt->fetch(PDO::FETCH_ASSOC)) && password_verify($heslo, @$existingUser['heslo'])){
        $_SESSION['uzivatel_id'] = $existingUser['uzivatel_id'];
        header('Location: index.php');
    }else{
        $formError="Invalid user or password!";
    }
}?><!DOCTYPE html>
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
if (!empty($formError)){
    echo '<p style="color:red;">'.$formError.'</p>';
}
?>

<form method="post">
    <label for="email">Váš email</label><br/>
    <input type="text" name="email" id="email" value="<?php echo htmlspecialchars(@$_POST['email'])?>"><br/><br/>

    <label for="heslo">heslo</label><br/>
    <input type="password" name="heslo" id="heslo" value=""><br/><br/>

    <input type="submit" value="Sign in">
</form>

<br/>

<a href="registrace.php">Registrovat se</a>

</body>
</html>