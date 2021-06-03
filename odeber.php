<?php
require 'db.php';

require 'overeni_uzivatele.php';

$id = $_GET['produkt_id'];
foreach ($_SESSION['kosik'] as $key => $value) {
    if ($key == $id) {
        $_SESSION["total"] -= intval($_SESSION['kosik'][$key]['quantity']);
        unset($_SESSION['kosik'][$key]);
    }
}

header('Location: kosik.php');
