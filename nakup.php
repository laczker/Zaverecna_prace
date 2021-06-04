<?php
require 'db.php';

require 'overeni_uzivatele.php';

if (isset($_SESSION['kosik']) && !empty($_SESSION['kosik'])) {

   $ids = [];
   foreach (@$_SESSION['kosik'] as $key => $value) {
      $ids[] = $key;
   }

   if (is_array($ids) && count($ids) > 0) {

      $question_marks = str_repeat('?,', count($ids) - 1) . '?';

      $stmt = $db->prepare("SELECT * FROM produkt WHERE produkt_id IN ($question_marks) ORDER BY nazev");
      $stmt->execute(array_values($ids));
      $goods = $stmt->fetchAll();
   }

   $stmt = $db->prepare("INSERT INTO objednavka (cena, pocet_kusu, id_uzivatel) VALUES (?, ?, ?)");
   $stmt->bindValue(1, $_SESSION['totalPrice']);
   $stmt->bindValue(2, $_SESSION['total']);
   $stmt->bindValue(3, $_SESSION["uzivatel_id"]);
   $stmt->execute();
   $id = $db->lastInsertId();

   foreach ($goods as $good) {
      $stmt = $db->prepare("INSERT INTO polozka_objednavky (produkt_id, objednavka_id, pocet_kusu) VALUES (?, ?, ?)");
      $stmt->bindValue(1, $good['produkt_id']);
      $stmt->bindValue(2, $id);
      $stmt->bindValue(3, $_SESSION['kosik'][$good['produkt_id']]['quantity']);
      $stmt->execute();
   }


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
