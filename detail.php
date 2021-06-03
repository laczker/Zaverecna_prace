<?php
require 'db.php';

require 'overeni_uzivatele.php';

$stmt = $db->prepare('SELECT * FROM produkt WHERE produkt.produkt_id=:produkt_id');
$stmt->execute([':produkt_id'=>@$_REQUEST['produkt_id']]);
$goods = $stmt->fetch(PDO::FETCH_ASSOC);

$produkt_id = $goods['produkt_id'];
$nazev=$goods['nazev'];
$popis=$goods['popis'];
$cena=$goods['cena'];
$kategorie_id=$goods['kategorie_id'];
$vyrobce_id=$goods['vyrobce_id'];
$parametry=$goods['parametry'];


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Můj košík</title>
    <link rel="stylesheet" type="text/css" href="./styles.css">
</head>
<body>

<?php include 'navbar.php' ?>

<h1>Detail produktu</h1>


<a href="index.php">Zpět na výběr zboží</a>

<br/><br/>

<?php
if (empty($goods)){
    echo 'Nebyl vybrán žádný produkt k zobrazení detailu';}
?>

<table>
        <tr><td>Název: <?php echo htmlspecialchars(@$nazev);?></td></tr>
        <tr><td>Popis: <?php echo htmlspecialchars(@$popis);?></td></tr>
        <tr><td>Cena: <?php echo @$cena;?></td></tr>
        <tr><td>Kategorie: <?php echo htmlspecialchars(@$kategorie_id);?></td></tr>
        <tr><td>Výrobce: <?php echo htmlspecialchars(@$vyrobce_id);?></td></tr>
        <tr><td>parametry: <?php echo htmlspecialchars(@$parametry);?></td></tr>
    <? if (($currentUser['role']=='admin')): ?>
        <tr><td><a href='uprav.php?produkt_id=<?php echo @$produkt_id; ?>'>Upravit</a></td></tr>
        <tr><td><a href='odeber.php?produkt_id=<?php echo @$produkt_id; ?>'>Odstranit</a></td></tr>
    <? endif; ?>
    <table/>

</html>