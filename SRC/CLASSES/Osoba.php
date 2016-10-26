<?php
namespace CLASSES;
class Osoba
{
    private $imie;
    private $nazwisko;

    public function __construct($i,$n)
    {
        $this->imie=$i;
        $this->nazwisko=$n;
    }

    public function setImie($i)
    {
       $this->imie=$i;
    }

    public function setNazwisko($n)
    {
        $this->nazwisko=$n;
    }

    public function getImie()
    {
        return $this->imie;
    }

    public function getNazwisko()
    {
        return $this->nazwisko;
    }

}

?>
