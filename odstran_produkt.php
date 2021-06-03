<?php

require 'db.php';

require 'overeni_admina.php';

$stmt = $db->prepare("DELETE FROM produkt WHERE produkt_id=?");
$stmt->execute([$_GET['produkt_id']]);

header('Location: index.php');