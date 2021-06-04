<?php
require 'db.php';

require 'overeni_uzivatele.php';

if (isset($_GET['id'])) {
   $stmt = $db->prepare("SELECT * FROM objednavka WHERE id = ?");
   $stmt->bindValue(1, $_GET['id']);
   $stmt->execute();
   $objednavka = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($objednavka['id_uzivatel'] != $currentUser['uzivatel_id']) {
      header("location: index.php");
   }


   $stmt = $db->prepare("SELECT * FROM produkt join polozka_objednavky using(produkt_id) where objednavka_id = ? ");
   $stmt->bindValue(1, $objednavka['id']);
   $stmt->execute();
   $polozky = $stmt->fetchAll();
} else {
   header("location: index.php");
}

?>

<h1>Detail Objednávky <?= $objednavka['id'] ?></h1>

<table>
   <thead>
      <tr>
         <th>Polozka</th>
         <th>Počet kusů</th>
         <th>cena</th>
         <th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($polozky as $polozka) : ?>
         <tr>
            <td><?= $polozka['nazev'] ?></td>
            <td><?= $polozka['pocet_kusu'] ?></td>
            <td><?= intval($polozka['pocet_kusu']) * intval($polozka['cena']) ?>Kč</td>
         </tr>
      <?php endforeach; ?>
   </tbody>
</table>

<a href="objednavky.php">Zpět</a>