<?php
require_once('vendor/autoload.php');
if(empty($_POST["txtImie"]) && empty($_POST["txtNazwisko"]) && empty($_POST["numPesel"]) && empty($_POST["txtFirma"]))
{
  print("Nie wypełniono wszystkich danych.");
}
else
{
  $imie = $_POST["txtImie"];
  $nazwisko = $_POST["txtNazwisko"];
  $pesel = $_POST["numPesel"];
  $firma = $_POST["txtFirma"];
  $sala = $_POST["selSala"];

  //utworzenie obiektu uzytkownik pod zmienna naukowiec
  $naukowiec = new CLASSES\Uzytkownik($imie,$nazwisko,$pesel,$firma);
  $naukowiec->addToEvents($sala);


  d($naukowiec);
}

 ?>
