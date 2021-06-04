<?php
require 'db.php';
require 'overeni_uzivatele.php';



$stmt = $db->prepare('SELECT * FROM produkt WHERE produkt.produkt_id=:produkt_id');
$stmt->execute([':produkt_id' => @$_REQUEST['produkt_id']]);
$goods = $stmt->fetch(PDO::FETCH_ASSOC);

$produkt_id = $goods['produkt_id'];
$nazev = $goods['nazev'];
$popis = $goods['popis'];
$cena = $goods['cena'];
$kategorie_id = $goods['kategorie_id'];
$vyrobce_id = $goods['vyrobce_id'];
$parametry = $goods['parametry'];


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Můj košík</title>
    <link rel="stylesheet" type="text/css" href="./styles.css">
</head>

<body>

    <?php
    if (empty($currentUser)) {
        include 'navbar_neprihlasen.php';
    } else {
        include 'navbar.php';
    }
    ?>

    <h1>Detail produktu</h1>


    <a href="index.php">Zpět na výběr zboží</a>

    <br /><br />

    <?php
    if (empty($goods)) {
        echo 'Nebyl vybrán žádný produkt k zobrazení detailu';
    }
    ?>

    <table>
        <tr>
            <td>Název: <?php echo htmlspecialchars(@$nazev); ?></td>
        </tr>
        <tr>
            <td>Popis: <?php echo htmlspecialchars(@$popis); ?></td>
        </tr>
        <tr>
            <td>Cena: <?php echo @$cena; ?></td>
        </tr>
        <tr>
            <td>Kategorie: <?php echo htmlspecialchars(@$kategorie_id); ?></td>
        </tr>
        <tr>
            <td>Výrobce: <?php echo htmlspecialchars(@$vyrobce_id); ?></td>
        </tr>
        <tr>
            <td>parametry: <?php echo htmlspecialchars(@$parametry); ?></td>
        </tr>
        <? if (isset($currentUser) && ($currentUser['role'] == 'admin')) : ?>
            <tr>
                <td><a href='uprav.php?produkt_id=<?php echo @$produkt_id; ?>'>Upravit</a></td>
            </tr>
            <tr>
                <td><a href='odeber.php?produkt_id=<?php echo @$produkt_id; ?>'>Odstranit</a></td>
            </tr>
        <? endif; ?>
        <table />


        <?php

        if (isset($_POST['telo_komentare'])) {
            $stmt = $db->prepare('INSERT INTO komentar (uzivatel_id, produkt_id, text) VALUES (?, ?, ?)');
            $stmt->bindValue(1, $currentUser['uzivatel_id']);
            $stmt->bindValue(2, $goods['produkt_id']);
            $stmt->bindValue(3, htmlspecialchars($_POST['telo_komentare'], ENT_QUOTES));
            $stmt->execute();
        }

        $stmt = $db->prepare('SELECT * FROM komentar join uzivatel using(uzivatel_id) WHERE produkt_id = ?');
        $stmt->bindValue(1, $goods['produkt_id']);
        $stmt->execute();
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h2>Komentáře</h2>
        <ul>
            <?php if (!empty($comments)) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <li><?= $comment['text'] ?> (<small><?= $comment['email'] ?></small>) <?= $comment['datum'] ?></li>
                <?php endforeach; ?>
            <?php endif ?>
        </ul>
        <p>Přidat komentář</p>
        <form method="POST">
            <textarea name="telo_komentare" id="telo_komentare" cols="30" rows="10"></textarea>
            <input type="submit" value="Okomentovat">
        </form>

</html>