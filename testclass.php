<?php

class Testclass{

    public function buildQuery($artikal, $lokal){

        $select = $this->buildSelect($lokal);
        $join = $this->buildJoin($lokal);
        $where = $this->buildWhere($artikal);
        $sql = $select . $join . $where . " ORDER BY artikli_lista.br_artikal;";

        return $sql;
    }

    private function buildSelect($lokal){

        $sql = "SELECT artikli_lista.br_artikal";

        foreach($lokal as $lokacija){

            $dodato = $lokacija . "_d";
            $sql .= ", $lokacija.zalihe AS $lokacija, $lokacija.dodato AS $dodato";

        }

        $sql = $sql . " FROM artikli_lista ";

        return $sql;
    }

    private function buildJoin($lokal){

        $sql = '';

        foreach($lokal as $lokacija){

            $sql = $sql . " LEFT JOIN $lokacija ON artikli_lista.br_artikal = $lokacija.br_artikal";

        }

        return $sql;
    }

    private function buildWhere($artikal){

        $prviArtikal = $artikal[0];
        $sql = " WHERE artikli_lista.br_artikal = '$prviArtikal'";
        $n = 0;

        foreach($artikal as $broj){

            if($n == 0){ 
                $n++;
                continue;
            }

            $sql = $sql . " OR artikli_lista.br_artikal = '$broj'";
        }

        return $sql;

    }
   
}

class TestclassController extends Testclass{

    private $artikal;
    private $lokal;

    public function getPodaci($lokal, $artikal){
        $this->artikal = $artikal;
        $this->lokal = $lokal;
    }

    public function getQuery(){
        $sql = $this->buildQuery($this->artikal, $this->lokal);
        return $sql;
    }

}

$lokal = ['adjustirnica', 'balistika', 'barbatovac', 'bazen', 'bujanovac', 'butik_bg', 'butik_vr'];
$artikal = ['A2000549', 'A2111976', 'A2015460', 'A2000428'];

$test = new TestclassController;
$test->getPodaci($lokal, $artikal);
$sql = $test->getQuery();
echo $sql; 