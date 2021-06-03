<?php
    require 'db.php';

    require 'overeni_uzivatele.php';

    if (!isset($_SESSION['kosik'])) {
    $_SESSION['kosik'] = [];
    }

    $stmt = $db->prepare("SELECT * FROM produkt WHERE produkt_id=?");
    $stmt->execute([$_GET['produkt_id']]);
    $goods = $stmt->fetch();

    if (!$goods){
    die("Neznámý produkt");
    }

    $_SESSION['kosik'][] = $goods["produkt_id"];

    header('Location: kosik.php');
