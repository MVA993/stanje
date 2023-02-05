<?php

class ArtikalView{

    public function redovi($brojac){
        
        $n = $brojac;
        
        for ($i=0; $i<=$n-1; $i++){
            echo "<tr>
                <td><input type='text' name='brojArtikla[]'></td>
                <td><input type='number' name='kolicina[]'></td>
                </tr>";
        }
    }

    public function rezultatPretrage($tabela){

        $i = 0;

        foreach ($tabela as $row){

            $razlika = $row['popisana kolicina'] - ($row['vec dodato'] + $row['dodati sada']);

            echo "<tr>";
                    echo "<td>";
                    if($razlika >= 0){
                        echo "<input type='hidden' name='belezi[".$i."][artikal]' value=".$row['artikal'].">";
                    }
                    echo strtoupper($row['artikal'])."</td>";

                    echo "<td>";
                    if($razlika >= 0){
                        echo "<input type='hidden' name='belezi[".$i."][lokacija]' value=".$row['lokacija'].">";
                    }
                    echo strtoupper(str_replace('_', ' ', $row['lokacija']))."</td>";

                    if($row['popisana kolicina'] == NULL){
                        echo "<td>0</td>";
                    }else{
                        echo "<td>".$row['popisana kolicina']."</td>";
                    }                    

                    if($row['vec dodato'] == NULL){
                        echo "<td>";
                        if($razlika >= 0){
                        echo "<input type='hidden' name='belezi[".$i."][dodato]' value=".$row['vec dodato'] + $row['dodati sada'].">";
                        }
                        echo "0</td>";
                    }else{
                        echo "<td>";
                        if($razlika >= 0){
                        echo "<input type='hidden' name='belezi[".$i."][dodato]' value=".$row['vec dodato'] + $row['dodati sada'].">";
                        }
                        echo $row['vec dodato']."</td>";
                    }

                    if($row['dodati sada'] == NULL){
                        echo "<td>";
                        if($razlika >= 0){
                        echo "<input type='hidden' name='belezi[".$i."][dodati]' value=".$row['dodati sada'].">";
                        }
                        echo "0</td>";
                    }else{
                        echo "<td>";
                        if($razlika >= 0){
                        echo "<input type='hidden' name='belezi[".$i."][dodati]' value=".$row['dodati sada'].">";
                        }
                        echo $row['dodati sada']."</td>";
                    }

                    if($razlika >= 0){
                        echo "<td>".$razlika."</td>";
                    }else{
                        echo "<td class='oprez'>".$razlika."</td>";
                    }

                    if($razlika >= 0){
                        echo "<td>Imate dovoljno količina na popisu. Klikom na dugme potvrđujete da ste stavili nove količine na stanje.</td>";
                    }else{
                        echo "<td class='oprez'>Količine koje želite da dodate prevazilaze popisanu količnu.</td>";
                    }

            echo "</tr>";

            $i++;

        }
    }

    public function showListaPromena($tabela){

        if(empty($tabela)){
            echo "Lista je prazna";
            exit;
        }

        echo "<h3> LISTA PROMENA </h3>";

        echo "<table>
                <tr>
                    <th>
                        BROJ ARTIKLA
                    </th>
                    <th>
                        LOKACIJA
                    </th>
                    <th>
                        STAVLJENO NA STANJE
                    </th>
                    <th>
                        VREME STAVLJANJA
                    </th>
                </tr>";

        foreach ($tabela as $row)
        {
            echo "<tr>";
            echo "<td>".$row['br_artikal']."</td>";
            echo "<td>".strtoupper(str_replace('_',' ',$row['lokacija']))."</td>";
            echo "<td>".$row['dodato']."</td>";
            echo "<td>".$row['datum']."</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
}