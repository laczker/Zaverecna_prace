<?php

session_start();

if(!isset($_SESSION["uzivatel_id"])){
    header('Location: index_neprihlasen.php');
    die();
}

$stmt = $db->prepare("SELECT * FROM uzivatel WHERE uzivatel_id = ? LIMIT 1");
$stmt->execute([$_SESSION["uzivatel_id"]]);

$currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentUser){
    session_destroy();
    header('Location: index.php');
    die();
}
