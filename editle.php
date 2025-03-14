<?php

    $envFile = __DIR__ . '/.env';
    if (file_exists($envFile)) {
        $env = parse_ini_file('.env');
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS']; 
        $dbName = $env['DB_NAME'];
    } else {
        die('.env hatasi.');
    }
    // error_reporting(E_ALL); ini_set("display_errors", 1);
    $db = mysqli_connect("localhost", "$user", "$pass", "$dbName");

    
    
    $referer = $_SERVER['HTTP_REFERER'];

    $databaseName = "universiteler";
    if (strpos($referer, "favoriler.php")) $databaseName = "favoriler";


    if (isset($_POST["universite"]) &&
        isset($_POST["fakulte"]) &&
        isset($_POST["unituru"]) &&
        isset($_POST["sehir"]) &&
        isset($_POST["ucret"]) &&
        isset($_POST["siralamalar"]) &&
        isset($_POST["kontenjanlar"]) &&
        isset($_POST["unikodu"])) {

        $universite = $_POST["universite"];
        $fakulte = $_POST["fakulte"];
        $unituru = $_POST["unituru"];
        $sehir = $_POST["sehir"];
        $ucret = $_POST["ucret"];
        $siralamalar = $_POST["siralamalar"];
        $kontenjanlar = $_POST["kontenjanlar"];
        $unikodu = $_POST["unikodu"];


        $guncelle = mysqli_query($db, "UPDATE ".$databaseName." SET universite='$universite', fakulte='$fakulte', unituru='$unituru', sehir='$sehir', ucret='$ucret', siralamalar='$siralamalar', kontenjanlar='$kontenjanlar' WHERE unikodu=$unikodu");
    
        header("Location: ".($databaseName=='universiteler' ? 'index' : 'favoriler').".php");
        
        
        
    } else {
        header("Location: ".($databaseName=='universiteler' ? 'index' : 'favoriler').".php");

    }


?>