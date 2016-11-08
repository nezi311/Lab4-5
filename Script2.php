<?php
require_once('vendor/autoload.php');
use CONFIG\dbconfig as DB;
DB::setDBConfig();
$pdo = DB::getHandle();

$stmt = $pdo -> query('SELECT id , nr_sali , id_naukowca, nauk.imie AS imie, nauk.nazwisko AS nazwisko, nauk.nazwa_firmy AS firma FROM zdarzenia AS zda, naukowcy AS nauk WHERE zda.id_naukowca = nauk.pesel ORDER BY zda.nr_sali*1');
// query wyświetla id, numer sali oraz id naukowca // tabeli zdarzenia zdarzenia nadajemy alias zda, tabeli naukowcy nadajemy alias nauk
//nastepnie wyszukujemy wszystkie pokoje w ktorych id_naukowca z tabeli zdarzenia odpowiada peselowi naukowca
// ostatecznie sortujemy wszystko rosnąco po numerze sali

$wynik = array(); // stworzenie nowej tablicy
while($row = $stmt -> fetch())  //wyciągnięcie danuch z zapytania metodą fetch()
{
  // wpisanie do tablicy o indexie nr_salim kolejnej tablicy tym razem asocjacyjnej z danymi naukowca
  $wynik[$row['nr_sali']][] = array(
    'pesel' => $row['id_naukowca'],
    'imie' => $row['imie'],
    'nazwisko' => $row['nazwisko'],
    'firma' => $row['firma']
  );
}
$stmt -> closeCursor();


foreach($wynik as $nr_sali => &$zdarzenia) // ?referencja ale skad do czego??? $nr_sali odnosnik do klucza , &$zdarzenia wartość z podanego klucza
{
  echo '<h3>' . $nr_sali. '</h3>'; // wypisanie numeru sali
  foreach($zdarzenia as &$zdarzenia) // ?referencja ale skad do czego??? uzycie referencji z poprzedniej petli?
  {
    echo '<p><i>'.$zdarzenia['pesel'].'</i> (Dane: '.$zdarzenia['imie'].' '.$zdarzenia['nazwisko'].' ,Firma:'.$zdarzenia['firma'].')';
    //wypisanie danych naukowcow, ktore zostały wpisane wcześniej z tablicy zdarzenia ktora jest referencja do tablicy wynik
  }
}
?>
