<?php
namespace CLASSES;

require_once('vendor/autoload.php');
//require_once('./classes/dbconfig.php');
use CONFIG\dbconfig as DB;
DB::setDBConfig();
$pdo = DB::getHandle();
use \PDO;

class Uzytkownik extends Osoba
{
        private $pesel;
    private $firma;

    public function __construct($i,$n,$p,$f)
    {
        parent::__construct($i,$n);

        if(is_numeric($p))
        {
            $this->pesel = $p;
            if($this->checkIfExists($p)==false)
            {
                try
                {
                    //$stmt = $pdo->query("INSERT naukowcy VALUES(94010104019,'Dawid','Dominiak','AsDa');");
                    $stmt = DB::getHandle() -> prepare('INSERT naukowcy VALUES (:pesel,:imie,:nazwisko,:nazwa_firmy)');
                    $stmt -> bindValue(':pesel',$p,PDO::PARAM_INT);
                    $stmt -> bindValue(':imie',$i,PDO::PARAM_STR);
                    $stmt -> bindValue(':nazwisko',$n,PDO::PARAM_STR);
                    $stmt -> bindValue(':nazwa_firmy',$f,PDO::PARAM_STR);
                    $liczba = $stmt -> execute();

                    if($liczba==0)
                        return false;
                }
                catch(PDOException $e)
                {
                    echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
                    return true;
                }
            }
        }
        else
        {
            print("Podany numer pesel nie jest liczbą");
        }
        $this->firma = $f;

    }

     public function getImie()
    {
       return parent::getImie();
    }

    public function getNazwisko()
    {
       return parent::getNazwisko();
    }

    public function getPesel()
    {
        return $this->pesel;
    }

    public function getFirma()
    {
        return $this->firma;
    }

    public function checkIfExists($p)
    {
        try
        {
            $stmt = DB::getHandle() -> prepare('SELECT * FROM naukowcy WHERE pesel = :pesel');
            $stmt -> bindValue(':pesel',$p,PDO::PARAM_STR);

            $stmt -> execute();
            $liczba = $stmt->rowCount();

            if($liczba==0 || $liczba==null)
                return false;
        }
        catch(PDOException $e)
        {
            echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
            return true;
        }


        return true;
    }



}

?>
