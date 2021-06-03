<?php
require 'db.php';

require 'overeni_uzivatele.php';

if (!isset($_SESSION['kosik'])) {
    $_SESSION['kosik'] = [];
}

$stmt = $db->prepare("SELECT * FROM produkt WHERE produkt_id=?");
$stmt->execute([$_GET['produkt_id']]);
$goods = $stmt->fetch();

if (!$goods) {
    die("Neznámý produkt");
}

// $_SESSION['kosik'][] = $goods["produkt_id"];
$priceUpdate = 0;
$quantity = htmlspecialchars($_GET["quantity"]);
if (isset($_SESSION['kosik'][$goods['produkt_id']]) && !isset($_GET['change'])) {
    $old_quantity = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']);
    $_SESSION['kosik'][$goods["produkt_id"]] = ["quantity" => intval($quantity) + $old_quantity];
    $priceUpdate = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']) * intval($goods['cena'])
        - $old_quantity * intval($goods['cena']);
} else if (isset($_SESSION['kosik'][$goods['produkt_id']]) && isset($_GET['change'])) {
    $old_quantity = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']);
    $_SESSION['kosik'][$goods["produkt_id"]] = ["quantity" => $quantity]; //přidání ID zboží do košíku
    $priceUpdate = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']) * intval($goods['cena'])
        - $old_quantity * intval($goods['cena']);;
} else {
    $_SESSION['kosik'][$goods["produkt_id"]] = ["quantity" => $quantity, "jednotkova_cena" => $goods['cena']];
    $priceUpdate = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']) * intval($goods['cena']);
}
if (!isset($_SESSION["totalPrice"])) {
    $_SESSION['totalPrice'] = $priceUpdate;
} else {
    $_SESSION['totalPrice'] = intval($_SESSION['totalPrice']) + $priceUpdate;
}
$totalGoods = 0;
foreach ($_SESSION['kosik'] as $key => $value) {
    $totalGoods += $value["quantity"];
}
// přidání proměnné celkového počtu produktů
$_SESSION['total'] = $totalGoods;

header('Location: kosik.php');
