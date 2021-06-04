<div class="navbar" style="overflow: auto; width: 100%; border-bottom: 1px solid black; padding: 10px 0;">
    <div style="float: left">

        <a href="index.php">Výběr produktů</a> |
        <a href="kosik.php">Můj košík</a>
        <a href="objednavky.php">Moje objednavky</a>

    </div>
    <div style="float: right">
        Přihlášený uživatel: <?php echo htmlspecialchars($currentUser['email']); ?> |
        <a href="odhlaseni.php">Odhlásit</a>
    </div>
</div>