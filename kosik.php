<?php
    require 'db.php';

    require 'overeni_uzivatele.php';

    $ids = @$_SESSION['kosik'];

    if (is_array($ids) && count($ids)>0) {

        $question_marks = str_repeat('?,', count($ids) - 1).'?';

        $stmt = $db->prepare("SELECT * FROM produkt WHERE produkt_id IN ($question_marks) ORDER BY nazev");
        $stmt->execute(array_values($ids));
        $goods = $stmt->fetchAll();
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Můj košík</title>
    <link rel="stylesheet" type="text/css" href="./styles.css">
</head>
<body>

<?php include 'navbar.php' ?>

<h1>Můj košík</h1>

Počet zboží v košíku: <strong><?php echo (!empty($goods)?count($goods):'0'); ?></strong>

<br/><br/>

<a href="index.php">Zpět na výběr zboží</a>

<br/><br/>

<?php
if (!empty($goods)){
    $sum=0;
    echo '<table>
                <thead>
                  <tr>
                    <th></th>
                    <th>Název</th>
                    <th>Počet kusů</th>
                    <th>Cena</th>
                    <th>Popis</th>
                  </tr>
                </thead>
                <tbody>';
    foreach ($goods as $good){
        echo '  <tr>
                    <td class="center">
                      <a href="odeber.php?produkt_id='.$good['produkt_id'].'">Odebrat</a>
                    </td>
                    <td>'.htmlspecialchars($good['nazev']).'</td>
                    <td class="right">'.$good['cena'].'</td>
                    <td>'.htmlspecialchars($good['popis']).'</td>
               </tr>';
        $sum+=$good['cena'];
    }
    echo '  </tbody>
                <tfoot>
                  <tr>
                    <td>SUM</td>
                    <td></td>
                    <td class="right">'.$sum.'</td>
                    <td></td>
                  </tr>
                </tfoot>                
              </table>';
}else{
    echo 'Žádné zboží v košíku';
}
?>
</body>
</html>