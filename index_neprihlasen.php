<?php

require 'db.php';

if (isset($_GET['offset'])) {
    $offset = (int)$_GET['offset'];
} else {
    $offset = 0;
}

$count = $db->query("SELECT COUNT(produkt_id) FROM produkt")->fetchColumn();

if (!empty($_GET['kategorie'])){
$stmt = $db->prepare("SELECT *, vyrobce.nazev AS nazev_vyrobce, produkt.nazev AS nazev_produkt, produkt.popis AS popis_produkt, kategorie.nazev AS nazev_kategorie FROM produkt JOIN vyrobce USING (vyrobce_id) JOIN kategorie USING (kategorie_id) WHERE produkt.kategorie_id=:kategorie ORDER BY produkt_id DESC LIMIT 5 OFFSET ?");
$stmt->bindValue(1, $offset, PDO::PARAM_INT);
$stmt->execute([':kategorie'=>$_GET['kategorie']]);
}else{
    $stmt = $db->prepare('SELECT *, vyrobce.nazev AS nazev_vyrobce, produkt.nazev AS nazev_produkt, produkt.popis AS popis_produkt, kategorie.nazev AS nazev_kategorie FROM produkt JOIN vyrobce USING (vyrobce_id) JOIN kategorie USING (kategorie_id) ORDER BY produkt_id DESC LIMIT 5 OFFSET ?');
    $stmt->bindValue(1, $offset, PDO::PARAM_INT);
    $stmt->execute();
  }
$produkt = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Eshop-zaverecna_prace</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<?php include 'navbar_neprihlasen.php' ?>

<h1>Eshop-zaverecna_prace</h1>

Počet produktů: <strong><?php echo $count;?></strong>

<?php
echo '<form method="get">
    <label for="kategorie">Kategorie:</label>
    <select name="kategorie" id="kategorie">
        <option value="">--nerozhoduje--</option>';

$ktg=$db->query('SELECT * FROM kategorie ORDER BY nazev;')->fetchAll(PDO::FETCH_ASSOC);
if (!empty($ktg)){
foreach ($ktg as $kategorie){
    echo '<option value="'.$kategorie['kategorie_id'].'"';
    if ($kategorie['kategorie_id']==@$_GET['kategorie']){
        echo ' selected="selected" ';
        }
        echo '>'.htmlspecialchars($kategorie['nazev']).'</option>';
        }
        }

        echo '  </select>
    <input type="submit" value="OK" class="d-none" />
</form>';?>


<?php if ($count>0){ ?>
    <table>
        <tr>
            <th></th>
            <th>Název</th>
            <th>Popis</th>
            <th>Cena</th>
            <th>Vyrobce</th>
        </tr>

        <?php foreach($produkt as $row){ ?>
            <tr>
                <td class="center">
                    <a href='detail.php?produkt_id=<?php echo $row['produkt_id']; ?>'>Detail</a>
                </td>
                <td><?php echo htmlspecialchars($row['nazev_produkt']); ?></td>
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
            echo '<a class="'.($offset/5+1==$i?'active':'').'" href="index_neprihlasen.php?offset='.(($i-1)*5).'">'.$i.'</a>';
        }
        ?>
    </div>
<?php } ?>

</body>
</html>