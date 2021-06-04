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

//promenna, ktera nakonec aktualizuje celkovou cenu v kosiku
$priceUpdate = 0;
$quantity = htmlspecialchars($_GET["quantity"]);
// Situace, kdy zboží již existuje v košíku a došlo k přidání zboží z index.php
if (isset($_SESSION['kosik'][$goods['produkt_id']]) && !isset($_GET['change'])) {
    //promenna je nutna pro aktualizaci celkove cenz
    $old_quantity = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']);
    //aktualizace kusu produkut
    $_SESSION['kosik'][$goods["produkt_id"]] = ["quantity" => intval($quantity) + $old_quantity];
    //od noveho poctu kusu odecteme stary pocet kusu => pricteme pocet kusu, ktere jsme pridali
    $priceUpdate = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']) * intval($goods['cena'])
        - $old_quantity * intval($goods['cena']);
}

//situace, kdy zbozi jiz existuje a  doslo k aktualizaci zbozi z kosik.php
// change je hidden input, ktery slouzi k identifikaci situace zmeny zbozi
else if (isset($_SESSION['kosik'][$goods['produkt_id']]) && isset($_GET['change'])) {
    $old_quantity = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']);
    $_SESSION['kosik'][$goods["produkt_id"]] = ["quantity" => $quantity]; //přidání ID zboží do košíku
    // stejny princip jako pri pridavani, ale tentokrat muze byt priceUpdate zaporna 
    $priceUpdate = intval($_SESSION['kosik'][$goods["produkt_id"]]['quantity']) * intval($goods['cena'])
        - $old_quantity * intval($goods['cena']);;
}
//situace kdy pridaveme nove zbozi
else {
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
