<?php
require 'db.php';

require 'overeni_uzivatele.php';
$stmt = $db->prepare("SELECT * FROM objednavka WHERE id_uzivatel = ?");
$stmt->bindValue(1, $currentUser['uzivatel_id']);
$stmt->execute();
$objednavky = $stmt->fetchAll();



?>

<table>
   <thead>
      <tr>

         <th>cena</th>
         <th>Počet kusů</th>
         <th>detail</th>
         <th>
      </tr>
   </thead>
   <tbody>
      <?php foreach ($objednavky as $objednavka) : ?>
         <tr>
            <td><?= $objednavka['cena'] ?>Kč</td>
            <td><?= $objednavka['pocet_kusu'] ?></td>
            <td><a href="detail_objednavky.php?id=<?= $objednavka['id'] ?>">detail</a></td>
         </tr>
      <?php endforeach; ?>
   </tbody>
</table>