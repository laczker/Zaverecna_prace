<?php

require 'db.php';
require 'overeni_uzivatele.php';

if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
} else {
    $offset = 0;
}

$count = $db->query("SELECT COUNT(produkt_id) FROM produkt")->fetchColumn();

$stmt = $db->prepare("SELECT *, vyrobce.nazev AS nazev_vyrobce, produkt.nazev AS nazev_produkt, produkt.popis AS popis_produkt FROM produkt JOIN vyrobce USING (vyrobce_id) ORDER BY produkt_id DESC LIMIT 5 OFFSET ?");
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->execute();

$produkt = $stmt->fetchAll(PDO::FETCH_ASSOC);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Eshop-zaverecna_prace</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php include 'navbar.php' ?>

<h1>Eshop-zaverecna_prace</h1>

Počet produktů: <strong><?php echo $count;?></strong>


<? if (($currentUser['role']=='admin')): ?>
    <br/><br/>
    <a href="novy_produkt.php">Nový produkt</a>
    <br/><br/>
<? else: ?>
    <br/><br/>
    <br/><br/>
<? endif; ?>



<?php if ($count>0){ ?>
    <table>
        <tr>
            <th></th>
            <th></th>
            <th>Název</th>
            <th>Popis</th>
            <th>Cena</th>
            <th>Vyrobce</th>
        </tr>

        <?php foreach($produkt as $row){ ?>
            <tr>
                <td class="center">
                    <a href='pridej.php?produkt_id=<?php echo $row['produkt_id']; ?>'>Přidat do košíku</a>
                </td>
                <td class="center">
                    <a href='detail.php?produkt_id=<?php echo $row['produkt_id']; ?>'>Detail</a>
                </td>
                <td><?php echo htmlspecialchars($row['nazev_produkt']);  ?></td>
                <td><?php echo htmlspecialchars($row['popis_produkt']); ?></td>
                <td class="right"><?php echo $row['cena']; ?></td>
                <td><?php echo htmlspecialchars($row['nazev_vyrobce']); ?></td>
            </tr>
        <?php } ?>
    </table>
    <br/>
    <div class="pagination">
        <?php
        for($i=1; $i<=ceil($count/5); $i++){
            echo '<a class="'.($offset/5+1==$i?'active':'').'" href="index.php?offset='.(($i-1)*5).'">'.$i.'</a>';
        }
        ?>
    </div>
<?php } ?>

</body>
</html>

