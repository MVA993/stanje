<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rezultat</title>
</head>
<style>

    table  {
        width: 100%;
        text-align: center;
    }

    td, th {
        padding-block: 5px;
        border: 2px solid black;
    }

    .oprez{
        color: red;
        text-align: center;
    }

    .kraj{
        border: none;
    }

</style>    
<body>
    <form action="povratak.inc.php" method="">
                <button type="submit">POČETNA STRANA</button>
    </form>
    <hr>
        <form action='zabelezi.inc.php' method='POST'>     
        <table>
            <tr>
                <th>
                    BROJ ARTIKLA
                </th>
                <th>
                    LOKACIJA
                </th>
                <th>
                    STANJE SA POPISA
                </th>
                <th>
                    VEĆ DODATE ZALIHE
                </th>
                <th>
                    ZALIHE ZA DODATI
                </th>
                <th>
                    RAZLIKA NAKON DODAVANJA
                </th>
                <th>                 
                </th>
            </tr>
            <?php

                include "../classes/dbconnect.class.php";
                include "../classes/artikal-model.class.php";
                include "../classes/artikal-controller.class.php";                
                include "../classes/artikal-view.class.php";
                
                if(isset($_POST['brojArtikla'])){
                    $_SESSION["artikal"] = array_filter($_POST['brojArtikla']);
                }

                if(isset($_POST['lokal'])){
                    $_SESSION["lokal"] = array_filter($_POST['lokal']);
                }

                if(isset($_POST['kolicina'])){
                    $_SESSION["kolicina"] = array_filter($_POST['kolicina']);
                }

                $artikal = $_SESSION["artikal"];
                $lokacija = $_SESSION["lokal"];
                $kolicina = $_SESSION["kolicina"];

                if(empty($artikal)){
                    echo "Nema više artikala za pregled!";
                    exit();
                }

                /*var_dump($artikal);
                echo "<br>";
                var_dump($lokacija);
                echo "<br>";
                var_dump($kolicina);
                echo "<br>";*/

                $baza = new DatabaseConnection();

                $stanje = new ArtikalController($baza->conn);
                $stanje->getAtributi($artikal, $lokacija, $kolicina);
                $tabela = $stanje->provera();

                $prikaz = new ArtikalView();
                $prikaz->rezultatPretrage($tabela);

            ?>
            <tr >
                <td class="kraj">
                </td>
                <td class="kraj">
                </td>
                <td class="kraj">
                </td>
                <td class="kraj">
                </td>
                <td class="kraj">
                </td>
                <td class="kraj">
                </td>
                <td class="kraj">  
                <button type="submit" name="submit">POTVRDI PROMENU</button>               
                </td>
            </tr>
        </table>        
        </form>
         <?php
            $lista = $stanje->listaPromena();
            $prikaz->showListaPromena($lista);    
         ?>

</body>
</html>