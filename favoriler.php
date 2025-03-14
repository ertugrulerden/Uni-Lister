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
    if (!$db) {
        die('Connection failed: ' . mysqli_connect_error());
    }
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>Yazılım Mühendisliği Bölümleri</title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="icon.webp">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="styles.css">
    <script src="script.js" defer></script>
    


</head>

<body>

    <h1 class="bg-dark text-white text-center py-4 rounded display-5 font-weight-bold">Favoriler</h1>

    <?php

        $action = isset($_GET['action']) ? $_GET['action'] : null;
        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        if ($action == 'sil' && $id) {
            $sil = mysqli_query($db, "DELETE FROM favoriler WHERE unikodu=$id");
            if ($sil) {
                echo '<div class="alert alert-success text-center">Kayıt başarıyla silindi.</div>';
            } else {
                echo '<div class="alert alert-danger text-center">Kayıt silinirken bir hata oluştu.</div>';
            }
        
            
        } else if ($action == 'editlemeModu' && $id){
            $liste = mysqli_query($db, "SELECT * FROM favoriler WHERE unikodu=$id");
            $row = mysqli_fetch_row($liste);

    ?>
            <div class="alert alert-info text-center" style="color: white;">Düzenleme:</div>
            <form action="editle.php" method="post" class="my-4">
                <div class="form-group">
                    <label style="color: white;">Üniversite</label>
                    <input type="text" class="form-control" name="universite" maxlength="60" value="<?php echo $row[0]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Fakülte</label>
                    <input type="text" class="form-control" name="fakulte" maxlength="60" value="<?php echo $row[1]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Tür</label>
                    <input type="text" class="form-control" name="unituru" maxlength="6" value="<?php echo $row[2]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Şehir</label>
                    <input type="text" class="form-control" name="sehir" maxlength="20" value="<?php echo $row[3]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Ücret</label>
                    <input type="text" class="form-control" name="ucret" maxlength="30" value="<?php echo $row[4]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Sıralamalar</label>
                    <input type="text" class="form-control" name="siralamalar" maxlength="60" value="<?php echo $row[5]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Kontenjanlar</label>
                    <input type="text" class="form-control" name="kontenjanlar" maxlength="60" value="<?php echo $row[6]; ?>">
                </div>

                <div class="form-group">
                    <label style="color: white;">Bölüm Kodu</label>
                    <input type="text" class="form-control" name="unikodu" maxlength="15" value="<?php echo $row[7]; ?>" readonly>
                </div>

                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>


    <?php
        } else if ($action == "ekle"){
    ?>      
            <div class="bg-dark alert rounded" style="color: white;">
                
                <div class="bg-dark alert rounded text-center" style="color: white;">Bölüm Ekleme:</div>
                <form action="ekle.php" method="post" class="my-4">
                    <div class="form-group">
                        <label style="color: white;">Üniversite</label>
                        <input type="text" class="form-control" name="universite" maxlength="60">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Fakülte</label>
                        <input type="text" class="form-control" name="fakulte" maxlength="60">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Tür</label>
                        <input type="text" class="form-control" name="unituru" maxlength="6">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Şehir</label>
                        <input type="text" class="form-control" name="sehir" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Ücret</label>
                        <input type="text" class="form-control" name="ucret" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Sıralamalar</label>
                        <input type="text" class="form-control" name="siralamalar" maxlength="60">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Kontenjanlar</label>
                        <input type="text" class="form-control" name="kontenjanlar" maxlength="60">
                    </div>
                    <div class="form-group">
                        <label style="color: white;">Bölüm Kodu</label>
                        <input type="text" class="form-control" name="unikodu" maxlength="15">
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Ekle</button>
                </form>

            </div>
            


    <?php
        }
    ?>

    <div class="d-flex align-items-center justify-content-between" style="padding: 10px;">
        <input id="searchbar" type="text" placeholder="🔎 Üniversite ara..." class="form-control rounded" style="width: 300px;">
        <a class="btn btn-warning" href="index.php">🔙 Geri Dön</a>
    </div>




    <div class="table-responsive my-4 rounded">
        <table class="table table-striped table-hover rounded">
            <thead class="table-dark">
                <tr>
                    <th scope="col" class="text-center"> <div class="centerTitles"><a class="btn btn-success" href="?action=ekle">+</a></div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Üniversite</div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Fakülte</div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Tür</div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Şehir</div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Ücret</div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Sıralama</div> </th>
                    <th scope="col" class="text-center"> <div class="centerTitles">Kontenjan </div> </th>
                    <th scope="col" class="text-center">YÖK</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $row_count = 0;
                    $liste = mysqli_query($db,"SELECT * FROM favoriler");
                    $favoriler = mysqli_query($db,"SELECT unikodu FROM favoriler");


                    while ( $row = mysqli_fetch_row($liste) ){
                        $checked = 0;
                        while ( $rowFavs = mysqli_fetch_row($favoriler) ){
                            if ($rowFavs[0] == $row[7]){
                                $checked = 1;
                                break;
                            }
                        }

                        
                        echo "<tr>";
                        echo "  <td class='text-center'>";
                        echo "      <a id='editleSil' class='btn btn-danger' href='?action=sil&id=$row[7]'>🗑️</a>";
                        echo "      <a id='editleSil' class='btn btn-primary' href='?action=editlemeModu&id=$row[7]' style='margin-top:10px'>🖊️</a>";
                        if ($checked){
                            echo "  <span id='star' class='fa fa-star checkedStar' style='font-size: 1.5rem; color: orange;  '></span>";
                        } else {
                            echo "
                                    <form method='POST' action='favla.php' style='display: inline;'>
                                        <input type='hidden' name='favID' value=".$row[7].">
                                        <button type='submit' style='background: none; border: none; padding: 0; cursor: pointer;'>
                                            <span id='star' class='fa fa-star' style='font-size: 1.5rem;'></span>
                                        </button>
                                    </form>";

                        }
                        echo "  </td>";
                    

                        for ($i = 0; $i<8; $i++){
                            if ($row[$i]==NULL or $row[$i]=="") continue;
                            
                            else if ($i == 7){
                                echo '<td class="text-center"><a href="https://yokatlas.yok.gov.tr/lisans.php?y='.$row[$i].'" target="_blank" class="btn btn-warning">🔗</a></td>';
                                continue;

                            } else if ($i == 5 || $i == 6) {
                                $array = explode("|", $row[$i]);

                                echo '<td class="text-center">';
                                for ($j = 0; $j < count($array); $j++) {
                                    if ($array[$j]=="NULL") $array[$j]="-";
                                    echo '<span class="h'.($j+4).'" >'.$array[$j].'</span>';

                                    if ($j < count($array) - 1) {
                                        echo "<br>";
                                    }
                                }
                                echo '</td>';

                                continue;
                            }

                            echo '<td class="text-center">'.$row[$i].'</td>';
                        }
                        echo "</tr>";
                        $row_count++;
                    }
                    
                    mysqli_free_result($liste);
                    mysqli_close($db);
                ?>
            </tbody>
        </table>
    </div>

</body>