<?php
require 'db.php';

require 'overeni_uzivatele.php';

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

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Můj košík</title>
  <link rel="stylesheet" type="text/css" href="./styles.css">
</head>

<body>

  <?php include 'navbar.php' ?>

  <h1>Můj košík</h1>

  Počet zboží v košíku: <strong><?php echo $_SESSION['total'] ?? 0; ?></strong>

  <br /><br />

  <a href="index.php">Zpět na výběr zboží</a>

  <br /><br />

  <?php
  if (!empty($goods)) {
    $sum = 0;
    echo '<table>
                <thead>
                  <tr>
                    <th></th>
                    <th>Název</th>
                    <th>Počet kusů</th>
                    <th>Cena</th>
                    <th>Popis</th>
                    <th>Aktualizovat pocet</th>
                    <th>
                  </tr>
                </thead>
                <tbody>';
    foreach ($goods as $good) {
      echo '  <tr>
                    <td class="center">
                      <a href="odeber.php?produkt_id=' . $good['produkt_id'] . '">Odebrat</a>
                    </td>
                    <td>' . htmlspecialchars($good['nazev']) . '</td>
                    <td class="right">' . floatval($_SESSION["kosik"][$good['produkt_id']]["quantity"]) . '</td>
                    <td class="right">' . floatval($good['cena']) *  floatval($_SESSION["kosik"][$good['produkt_id']]["quantity"]) .
        'Kč (' . floatval($good['cena']) . ' kč za jednotku) </td>
                    <td>' . htmlspecialchars($good['popis']) . '</td>
                    <td>
                    <form action="pridej.php" method="GET">
                    <input type="number" name="quantity" id="quantity" min="1" value="' . $_SESSION["kosik"][$good['produkt_id']]["quantity"] . '">
                    <input name="produkt_id" type="hidden" value="' . $good['produkt_id'] . '" />
                    <input name="change" type="hidden" value="" />
                    <input type="submit" value="Změnit" />
                 </form>
                    </td>
               </tr>';
      $sum += floatval($good['cena']) * floatval($_SESSION["kosik"][$good['produkt_id']]["quantity"]);
    }
    echo '  </tbody>
                <tfoot>
                  <tr>
                    <td>Celková Cena</td>
                    <td></td>
                    <td class="right">' . $_SESSION['totalPrice'] . '</td>
                    <td></td>
                  </tr>
                </tfoot>                
              </table>';

    echo "<a href='nakup.php'> Objednat </a>";
  } else {
    echo 'Žádné zboží v košíku';
  }
  ?>
</body>

</html>