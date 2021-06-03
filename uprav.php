<?php

require 'db.php';

require 'overeni_admina.php';

$stmt = $db->prepare('SELECT produkt.*, uzivatel.email, now() > cas_posledni_upravy + INTERVAL 5 MINUTE AS cas_vyprsel FROM produkt LEFT JOIN uzivatel ON uzivatel.uzivatel_id=produkt.posledni_upravu_provedl WHERE produkt.produkt_id=:produkt_id');
$stmt->execute([':produkt_id'=>@$_REQUEST['produkt_id']]);
$goods = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$goods){

    die("Toto zboží neexistuje!");
}

$nazev=$goods['nazev'];
$popis=$goods['popis'];
$cena=$goods['cena'];
$kategorie_id=$goods['kategorie_id'];
$vyrobce_id=$goods['vyrobce_id'];
$parametry=$goods['parametry'];


if (
    !empty($goods["posledni_upravu_provedl"]) &&
    $goods["posledni_upravu_provedl"] != $currentUser['uzivatel_id'] &&
    !$goods['edit_expired']
){
    die("Produkty právě upravuje uživatel: ".$goods['email']);
}

$stmt = $db->prepare("UPDATE produkt SET cas_posledniho_updatu=NOW(), posledni_upravu_provedl=:uzivatel WHERE produkt_id=:produkt_id");
$stmt->execute([':uzivatel'=> $currentUser["uzivatel_id"], ':produkt_id'=> $_GET['produkt_id']]);

if (!empty($_POST)) {
    $formErrors='';

    //TODO tady by měly být nějaké kontroly odeslaných dat, že :)

    $nazev=$_POST['nazev'];
    $popis=$_POST['popis'];
    $cena=floatval($_POST['cena']);
    $kategorie_id=$_POST['kategorie_id'];
    $vyrobce_id=$_POST['vyrobce_id'];
    $parametry=$_POST['parametry'];

    if (empty($formErrors)){
        $stmt = $db->prepare('UPDATE produkt SET nazev=:nazev, popis=:popis, cena=:cena, kategorie_id=:kategorie_id, vyrobce_id=:vyrobce_id, parametry=:parametry, posledni_upravu_provedl=NULL, cas_posledniho_updatu=NULL WHERE produkt_id=:produkt_id LIMIT 1;');
        $stmt->execute([
            ':nazev'=> $nazev,
            ':popis'=> $popis,
            ':cena'=>$cena,
            ':kategorie_id'=>$kategorie_id,
            ':vyrobce_id'=>$vyrobce_id,
            ':parametry'=>$parametry,
            ':produkt_id'=> $goods['produkt_id']
        ]);

        header('Location: index.php');
        exit();
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>PHP Shopping App</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php include 'navbar.php' ?>

<h1>Úprava produktu</h1>

<?php
if (!empty($formErrors)){
    echo '<p style="color:red;">'.$formErrors.'</p>';
}
?>

<form method="post">
    <label for="nazev">Název</label><br/>
    <input type="text" name="nazev" id="nazev" value="<?php echo htmlspecialchars(@$nazev);?>" required><br/><br/>

    <label for="popis">Popis</label><br/>
    <textarea name="popis" id="popis"><?php echo htmlspecialchars(@$popis)?></textarea><br/><br/>

    <label for="cena">Cena<br/>
        <input type="number" min="0" name="cena" id="cena" required value="<?php echo htmlspecialchars(@$cena)?>"><br/><br/>

        <div class="form-group">
            <label for="kategorie_id">Kategorie:</label>
            <select name="kategorie_id" id="kategorie_id" required class="form-control <?php echo (!empty($errors['kategorie_id'])?'is-invalid':''); ?>">
                <option value="">--vyberte--</option>
                <?php
                $categoryQuery=$db->prepare('SELECT * FROM kategorie ORDER BY nazev;');
                $categoryQuery->execute();
                $categories=$categoryQuery->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($categories)){
                    foreach ($categories as $category){
                        echo '<option value="'.$category['kategorie_id'].'" '.($category['kategorie_id']==@$kategorie_id?'selected="selected"':'').'>'.htmlspecialchars($category['nazev']).'</option>';
                    }
                }
                ?>
            </select>
            <?php
            if (!empty($errors['kategorie_id'])){
                echo '<div class="invalid-feedback">'.$errors['kategorie_id'].'</div>';
            }
            ?>
        </div>

        <div class="form-group">
            <label for="vyrobce_id">Výrobce:</label>
            <select name="vyrobce_id" id="vyrobce_id" required class="form-control <?php echo (!empty($errors['vyrobce_id'])?'is-invalid':''); ?>">
                <option value="">--vyberte--</option>
                <?php
                $brandQuery=$db->prepare('SELECT * FROM vyrobce ORDER BY nazev;');
                $brandQuery->execute();
                $brands=$brandQuery->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($brands)){
                    foreach ($brands as $brand){
                        echo '<option value="'.$brand['vyrobce_id'].'" '.($brand['vyrobce_id']==@$vyrobce_id?'selected="selected"':'').'>'.htmlspecialchars($brand['nazev']).'</option>';
                    }
                }
                ?>
            </select>
            <?php
            if (!empty($errors['vyrobce_id'])){
                echo '<div class="invalid-feedback">'.$errors['vyrobce_id'].'</div>';
            }
            ?>
        </div>

        <label for="parametry">Parametry</label><br/>
        <textarea name="parametry" id="parametry"><?php echo htmlspecialchars(@$parametry)?></textarea><br/><br/>

        <input type="submit" value="Ulož">
        <a href="index.php">Zruš</a>
</form>

</body>

</html>
