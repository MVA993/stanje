<?php

    class Artikal {

        private $baza;

        function __construct($baza)
        {
            $this->baza = $baza;
        }
        
        protected function runQuery($artikal, $lokal)
        {

            $sql = $this->buildQuery($artikal, $lokal);
            $result = $this->baza->query($sql);
            
            if($result->num_rows > 0){
                $tabela = $result->fetch_all(MYSQLI_ASSOC);
                return $tabela;
            }else{
                return false;
            }
        }

        private function buildQuery($artikal, $lokal)
        {

            $select = $this->buildSelect($lokal);
            $join = $this->buildJoin($lokal);
            $where = $this->buildWhere($artikal);
            $sql = $select . $join . $where . " ORDER BY artikli_lista.br_artikal;";
    
            return $sql;
        }
    
        private function buildSelect($lokal)
        {
    
            $sql = "SELECT artikli_lista.br_artikal";
    
            foreach($lokal as $lokacija){

                $dodato = $lokacija . "_d";
                $sql .= ", $lokacija.zalihe AS $lokacija, $lokacija.dodato AS $dodato";
    
            }
    
            $sql .= " FROM artikli_lista ";
    
            return $sql;
        }
    
        private function buildJoin($lokal)
        {
    
            $sql = '';
    
            foreach($lokal as $lokacija){
    
                $sql .= " LEFT JOIN $lokacija ON artikli_lista.br_artikal = $lokacija.br_artikal";
    
            }
    
            return $sql;
        }
    
        private function buildWhere($artikal)
        {
    
            $prviArtikal = $artikal[0];
            $sql = " WHERE artikli_lista.br_artikal = '$prviArtikal'";
            $n = 0;
    
            foreach($artikal as $broj){
    
                if($n == 0){ 
                    $n++;
                    continue;
                }
    
                $sql .= " OR artikli_lista.br_artikal = '$broj'";
            }
    
            return $sql;
    
        }

        protected function updateLokaciju($beleska)
        {
            foreach ($beleska as $row){

                $dodato = $row['dodato'];
                $lokacija = $row['lokacija'];
                $artikal = $row['artikal'];

                if($dodato == NULL || $dodato == 0 ){
                    exit();
                }

                $sql = "UPDATE $lokacija
                SET dodato = '$dodato'
                WHERE br_artikal = '$artikal'";

                $this->baza->query($sql);

            }
        }

        protected function updatePromene($beleska)
        {

        $sql = "INSERT INTO promene (br_artikal, lokacija, dodato)
                VALUES ";

        $i = 0;

            foreach ($beleska as $row){

                $dodati = $row['dodati'];
                $lokacija = $row['lokacija'];
                $artikal = $row['artikal'];

                if($dodati == NULL || $dodati == 0 ){
                    exit();
                }

                if($i == 0){                    
                    $sql .= "('$artikal', '$lokacija', '$dodati')";
                    $i++;
                    continue;
                }

                $sql .= ",('$artikal', '$lokacija', '$dodati')";

            }            

        $this->baza->query($sql);

        }

        protected function getListaPromena()
        {
            $sql = "SELECT br_artikal, lokacija, dodato, datum
            FROM promene
            ORDER BY datum DESC";

            $result = $this->baza->query($sql);

            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }
    }