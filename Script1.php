<?php
require_once('vendor/autoload.php');
$imie = $_POST["txtImie"];
$nazwisko = $_POST["txtNazwisko"];
$pesel = $_POST["numPesel"];
$firma = $_POST["txtFirma"];

//utworzenie obiektu uzytkownik pod zmienna naukowiec
$naukowiec = new CLASSES/Uzytkownik($imie,$nazwisko,$php,$firma);
d($naukowiec);

 ?>
