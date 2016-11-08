<?php
require_once('vendor/autoload.php');
//require_once('./classes/dbconfig.php');
use CONFIG\dbconfig as DB;
DB::setDBConfig();
$pdo = DB::getHandle();

try
{
    $stmt = $pdo->query("DROP TABLE IF EXISTS `zdarzenia`");
    //d($stmt);
    $stmt = $pdo->query("DROP TABLE IF EXISTS `naukowcy`");
    //d($stmt);

    $stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `naukowcy` ( `pesel` BIGINT NOT NULL , `imie` VARCHAR(50) NOT NULL , `nazwisko` VARCHAR(100) NOT NULL , `nazwa_firmy` VARCHAR(100) NOT NULL , PRIMARY KEY (`pesel`)) ENGINE = InnoDB;");


    //d($stmt);


    $stmt = $pdo->query("CREATE TABLE IF NOT EXISTS `zdarzenia` ( `id` INT NOT NULL AUTO_INCREMENT , `nr_sali` VARCHAR(10) NOT NULL , `id_naukowca` BIGINT NOT NULL , PRIMARY KEY (`id`),FOREIGN KEY (id_naukowca) REFERENCES naukowcy(pesel) ON DELETE CASCADE) ENGINE = InnoDB;");



    //$ob1 = new CLASSES\Uzytkownik('Dawid','Dominiak',94010104019,'AsDa');
    // d($ob1);

    //$ob2 = new CLASSES\Uzytkownik('Dawid','Dominiak',94010104019,'AsDa');
    // d($ob2);


    //d($stmt);

    $stmt = $pdo->query("INSERT naukowcy VALUES(94051904017,'Dawid','Dominiak','AsDa');");
    //d($stmt);
    $stmt = $pdo->query("INSERT naukowcy VALUES(94011104019,'Damian','Krupnik','DDas');");
    //d($stmt);
    $stmt = $pdo->query("INSERT naukowcy VALUES(94010654789,'Bartosz','Nagato','AssDa');");
    //d($stmt);
    $stmt = $pdo->query("INSERT naukowcy VALUES(94051632145,'Andrzej','Kowalski','Anonimowi Anrzeje');");
    //d($stmt);
    $stmt = $pdo->query("INSERT naukowcy VALUES(94326547891,'Janek','Mielczarek','Janki z czarnolasu');");
    //d($stmt);



    $stmt = $pdo->query("INSERT zdarzenia VALUES(NULL,'310',94051904017);");
    d($stmt);
    $stmt = $pdo->query("INSERT zdarzenia VALUES(NULL,'311',94051904017);");
    d($stmt);
    $stmt = $pdo->query("INSERT zdarzenia VALUES(NULL,'200',94011104019);");
    d($stmt);
    $stmt = $pdo->query("INSERT zdarzenia VALUES(NULL,'11',94010654789);");
    d($stmt);
    $stmt = $pdo->query("INSERT zdarzenia VALUES(NULL,'20',94051632145);");
    d($stmt);
    $stmt = $pdo->query("INSERT zdarzenia VALUES(NULL,'114',94326547891);");
    d($stmt);



 print("<h1>Zainicjalizowano bazę danych.</h1>");

}

catch(PDOException $e)
{
		echo 'Wystąpił błąd biblioteki PDO: ' . $e->getMessage();
}



?>
