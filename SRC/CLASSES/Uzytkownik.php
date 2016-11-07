<?php
namespace CLASSES;

require_once('vendor/autoload.php');
//require_once('./classes/dbconfig.php');
//załączenie pliku konfiguracyjnego do bazy danych
use CONFIG\dbconfig as DB;
DB::setDBConfig();
$pdo = DB::getHandle(); // załączenie uchwytu do wykonywania poleceń na bazie danych
use \PDO;

class Uzytkownik extends Osoba
{
    private $pesel;
    private $firma;

    public function __construct($i,$n,$p,$f)
    {
        parent::__construct($i,$n);

        // sprawdzenie czy pesel jest liczbą
        // funkcja is_numeric zwraca true lub false jeśli podana zmienna jest liczbą
        if(is_numeric($p))
        {
            $this->pesel = $p; // przypisanie pod zmienną pesel wartości liczbowej ze zemiennej $p
            if($this->checkIfExists($p)==false) // sprawdzenie za pomocą metody checkIfExists czy naukowiec o podanym numerze pesel istnieje juz w bazie danych
            {
                try
                {
                    // przygotowanie zapytania sql
                    $stmt = DB::getHandle() -> prepare('INSERT naukowcy VALUES (:pesel,:imie,:nazwisko,:nazwa_firmy)');
                    $stmt -> bindValue(':pesel',$p,PDO::PARAM_INT); // podpinanie parametrow do zapytania
                    $stmt -> bindValue(':imie',$i,PDO::PARAM_STR);
                    $stmt -> bindValue(':nazwisko',$n,PDO::PARAM_STR);
                    $stmt -> bindValue(':nazwa_firmy',$f,PDO::PARAM_STR);
                    $wynik_zapytania = $stmt -> execute(); // wykonanie zapytania

                    if($wynik_zapytania)
                    {
                      print("<br>Udało się dodać naukowca $i $n");
                    }
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
            print("<br>Podany numer pesel nie jest liczbą");
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

    // metoda checkIfExists sprawdza czy podany numer pesel istnieje w bazie danych, zwraca true jeśli istnieje lub false jeśli nie istnieje
    public function checkIfExists($p)
    {
        try
        {
            $stmt = DB::getHandle() -> prepare('SELECT * FROM naukowcy WHERE pesel = :pesel'); // przygotowanie zapytania do bazy danych

            // podpięcie parametrow pod przygotowany uchwyt :pesel
            // robimy to w celu profilaktycznym, aby atak sql_injection sie nie powiodl
            $stmt -> bindValue(':pesel',$p,PDO::PARAM_STR);

            $stmt -> execute(); // wykonujemy zapytanie
            $liczba = $stmt->rowCount(); // zliczamy ilość wierszy ktore zwroci zapytanie

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

    // metoda ma za zadanie pokazywać wynajete przez naukowca pokoje
    public function showRooms()
    {
      try
      {
        $stmt = DB::getHandle() -> prepare('SELECT * FROM zdarzenia WHERE id_naukowca = :tempPesel');
        $stmt -> bindValue(':tempPesel',$this->pesel,PDO::PARAM_INT);
        $stmt -> execute();
        //$row=$stmt -> fetch(PDO::FETCH_ASSOC);

        if($stmt!=false)
        {
          $tempImie = parent::getImie();
          $tempNazwisko = parent::getNazwisko();
          print("<h1>Sale wynajęte przez naukowca $tempImie $tempNazwisko .</h1>");
          while($row=$stmt -> fetch(PDO::FETCH_ASSOC))
          {
            $sala = $row["nr_sali"];
            print('<h3>nr sali : '.$sala.'<h3>');
          }
        }
      }
      catch(PDOException $e)
      {
        	echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
      }
    }

    public function addToEvents($ev)
    {
      try
      {
        $stmt = DB::getHandle() -> prepare('INSERT zdarzenia VALUES (NULL,:nr,:naukowiec)'); // przygotowanie zapytania do bazy danych

        // podpięcie parametrow pod przygotowany uchwyt :pesel
        // robimy to w celu profilaktycznym, aby atak sql_injection sie nie powiodl
        $stmt -> bindValue(':nr',$ev,PDO::PARAM_STR);
        $stmt -> bindValue(':naukowiec',$this->pesel,PDO::PARAM_INT);


        $stmt -> execute(); // wykonujemy zapytanie

        if($stmt!=false)
        {
          print("Udało się wynająć pokoj.");
          $this->showRooms();
        }



      }
      catch(PDOException $e)
      {
        	echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
      }

    }



}

?>
