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
    $dbUni = mysqli_connect("localhost", "$user", "$pass", "$dbName");


    if (isset($_POST["favID"])) {
            
        $eklenecekUniRow = mysqli_query($dbUni, "SELECT * FROM universiteler WHERE unikodu='".mysqli_real_escape_string($dbUni, $_POST["favID"])."'");

        echo "num rows: ".mysqli_num_rows($eklenecekUniRow)."<br> favID: ".$_POST["favID"]."<br>";

        if ($eklenecekUniRow && mysqli_num_rows($eklenecekUniRow) > 0) {
            $eklenecekUni = mysqli_fetch_row($eklenecekUniRow);

            $universite = $eklenecekUni[0];
            $fakulte = $eklenecekUni[1];
            $unituru = $eklenecekUni[2];
            $sehir = $eklenecekUni[3];
            $ucret = $eklenecekUni[4];
            $siralamalar = $eklenecekUni[5];
            $kontenjanlar = $eklenecekUni[6];
            $unikodu = $eklenecekUni[7];

            echo $universite."<br>";
            echo $fakulte."<br>";
            echo $unituru."<br>";
            echo $sehir."<br>";
            echo $ucret."<br>";
            echo $siralamalar."<br>";
            echo $kontenjanlar."<br>";
            echo $unikodu."<br>";




            $ekle = mysqli_query($dbUni, "INSERT INTO favoriler (universite, fakulte, unituru, sehir, ucret, siralamalar, kontenjanlar, unikodu) 
            VALUES ('$universite', '$fakulte', '$unituru', '$sehir', '$ucret', '$siralamalar', '$kontenjanlar', '$unikodu')");

            if (!$ekle) {
                die("Error inserting data: " . mysqli_error($dbUni));
            }
        }
        

        header("Location: favoriler.php");


    } else {
        header("Location: index.php");
    }


?>