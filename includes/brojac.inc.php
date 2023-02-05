<form action='provera.inc.php' method='POST'>
        <table>
            <tr>
                <th>Broj artikla </th>
                <th>Količina </th>
            </tr>

<?php

$n = $_POST['brojReda'];

if($n <= 0){
    header ("location:../index.php?error=nocounter");
    exit();
}

include "../classes/artikal-view.class.php";

$redovi = new ArtikalView();
$redovi->redovi($n);

?>
        </table>
        <br>
<?php

include "lokacije.inc.php";

?>
        <button type='submit'>Pretraži</button>
        </form>
            
        <form action='../index.php' method=''>
            <button type='submit'>Povratak</button>
        </form>

</html>

