<?php
require 'db.php';

require 'overeni_uzivatele.php';

if (isset($_SESSION['kosik']) && !empty($_SESSION['kosik'])) {

   $stmt = $db->prepare("INSERT INTO objednavka (cena, pocet_kusu, id_uzivatel) VALUES (?, ?, ?)");
   $stmt->bindValue(1, $_SESSION['totalPrice']);
   $stmt->bindValue(2, $_SESSION['total']);
   $stmt->bindValue(3, $_SESSION["uzivatel_id"]);
   $stmt->execute();
   unset($_SESSION['kosik']);
   unset($_SESSION['total']);
   unset($_SESSION['totalPrice']);
   echo "
   <p> Objednávka založeba </p>
   <a href='index.php'>Zpět</a>
   ";
} else {
   echo "<p> Kosik je prazdny </p> <a href='index.php'>Zpět</a>";
}
