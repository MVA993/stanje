<?php

class ArtikalController extends Artikal
{
    private $artikal;
    private $lokacija;
    private $kolicina;

    public function getAtributi($artikal, $lokacija, $kolicina)
    {
        $this->artikal = $artikal;
        $this->lokacija = $lokacija;
        $this->kolicina = $kolicina;
    }


    public function promena($beleska)
    {
        $this->updateLokaciju($beleska);
        $this->updatePromene($beleska);
    }

    public function provera()
    {
        $tabela = $this->runQuery($this->artikal, $this->lokacija);
        $nA = count($this->artikal);
        $nL = count($this->lokacija);

        foreach ($tabela as $red) {

            for ($i = 0; $i < $nA; $i++) {

                for ($j = 0; $j < $nL; $j++) {

                    if ($this->artikal[$i] != $red['br_artikal']) {
                        continue;
                    }

                    $result[] = array("artikal" => $this->artikal[$i], "dodati sada" => $this->kolicina[$i], 'lokacija' => $this->lokacija[$j], 'popisana kolicina' => $red[$this->lokacija[$j]], "vec dodato" => $red[$this->lokacija[$j] . "_d"]);

                }

            }
        }

        return $result;
    }

    private function getTabela()
    {
        $tabela = $this->runQuery($this->artikal, $this->lokacija);

        if ($tabela == false) {
            echo "<h2>Nema rezultata.</h2>";
            exit();
        } else {
            return $tabela;
        }
    }

    public function listaPromena()
    {
        if($this->getListaPromena() == false){
            exit;
        }

        $upit = $this->getListaPromena();
        $tabela = $upit->fetch_all(MYSQLI_ASSOC);
        return $tabela;        
    }

}