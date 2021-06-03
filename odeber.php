<?php
require 'db.php';

require 'overeni_uzivatele.php';

$id = $_GET['produkt_id'];
foreach ($_SESSION['kosik'] as $key => $value){
    if ($value == $id) {
        unset($_SESSION['kosik'][$key]);
    }
}

header('Location: kosik.php');