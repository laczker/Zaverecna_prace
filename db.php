<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=eshop;charset=utf8', 'ninja', 'ninja');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
