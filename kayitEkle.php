<html>
<body>
    <form action="kayitEkle.php" name="kayitekle" method="GET">
        Bolum No: <input type="number" name="bolumnoInput" value=""> <br>
        Bolum Ad: <input type="text" name="bolumadInput" value=""> <br>
        Bolum Konum: <input type="text" name="konumInput" value=""> <br>
        <input type="submit" value="Ekle" name="ekle">
    </form>

    <?php
        error_reporting(E_ALL); ini_set("display_errors", 1);

        $db = mysqli_connect("localhost", "root", "", "personel");

        if ( isset($_GET["bolumnoInput"]) and isset($_GET["bolumadInput"]) and isset($_GET["konumInput"]) ){
            $bolumnoInput = $_GET["bolumnoInput"];
            $bolumadInput = $_GET["bolumadInput"];
            $konumInput = $_GET["konumInput"];

            $ekle = mysqli_query($db, "INSERT INTO bolum values($bolumnoInput, '$bolumadInput', '$konumInput')");
        }
        
        $a = 1;
        echo "<table border=1>";
        $liste = mysqli_query($db,"SELECT * FROM bolum");
        while ( $row = mysqli_fetch_row($liste) ){
            if ($a==1) {
                echo "<tr style='background-color: #0055ff;'>";
                $a = 0;
            } else {
                echo "<tr style='background-color: #003399;'>";
                $a = 1;
            }
            for ($i = 0; $i<3; $i++){
                echo "<td> ".$row[$i]." </td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        mysqli_free_result($liste);
        mysqli_close($db);
    ?>
</body>
</html>