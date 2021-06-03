<?php

require 'db.php';

require 'overeni_admina.php';

if (!empty($_POST)){
    $formErrors='';

    //TODO tady by měly být nějaké kontroly odeslaných dat, že :)

    if (empty($formErrors)){
        $stmt = $db->prepare("INSERT INTO produkt(nazev, popis, cena, kategorie_id, vyrobce_id, parametry) VALUES (:nazev, :popis, :cena, :kategorie_id, :vyrobce_id, :parametry)");
        $stmt->execute([
            ':nazev'=>$_POST['nazev'],
            ':popis'=>$_POST['popis'],
            ':cena'=>floatval($_POST['cena']),
            ':kategorie_id'=>$_POST['kategorie_id'],
            ':vyrobce_id'=>$_POST['vyrobce_id'],
            ':parametry'=>$_POST['parametry']
        ]);
    }

    //přesměrování na homepage
    header('Location: index.php');
    exit();
}
?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Eshop-zaverecna_prace</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    </head>
<body>
    <?php include 'navbar.php' ?>

    <h1>Nový produkt</h1>

    <?php
    if (!empty($formErrors)){
        echo '<p style="color:red;">'.$formErrors.'</p>';
    }
    ?>

<form method="post">
        <label for="nazev">Název</label><br/>
        <input type="text" name="nazev" id="nazev" value="<?php echo htmlspecialchars(@$_POST['nazev']);?>" required><br/><br/>

        <label for="popis">Popis</label><br/>
        <textarea name="popis" id="popis"><?php echo htmlspecialchars(@$_POST['popis'])?></textarea><br/><br/>

        <label for="cena">Cena<br/>
        <input type="number" min="0" name="cena" id="cena" required value="<?php echo htmlspecialchars(@$_POST['cena'])?>"><br/><br/>

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
                            echo '<option value="'.$category['kategorie_id'].'" '.($category['kategorie_id']==@$_POST['kategorie_id']?'selected="selected"':'').'>'.htmlspecialchars($category['nazev']).'</option>';
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
                            echo '<option value="'.$brand['vyrobce_id'].'" '.($brand['vyrobce_id']==@$_POST['vyrobce_id']?'selected="selected"':'').'>'.htmlspecialchars($brand['nazev']).'</option>';
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
        <textarea name="parametry" id="parametry"><?php echo htmlspecialchars(@$_POST['parametry'])?></textarea><br/><br/>

        <input type="submit" value="Ulož">
            <a href="index.php">Zruš</a>
</form>

</body>
</html>