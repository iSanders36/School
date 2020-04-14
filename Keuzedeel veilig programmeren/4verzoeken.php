
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
<form action="" method="get">
  <h1>Form voor GET</h1>
  <label>Naam:</label><input type="text" name="naam"/>

  <label>Achternaam:</label><input type="text" name="achternaam"/>

  <input type="submit"/>
</form>

<br>

<!-- Hij kijkt doormiddel van if statement of er iets zit in de GET parameter zit. Als dat het  niet geval is voert hij dat niks uit en vraagt je om voor en achternaam in te vullen
De _GET parameters worden gevuld doormiddel van een form en worden opgehaald uit name. Je kunt er op dit moment nog tekens invoeren om het te manipuleren -->
<?php
if (empty($_GET))
{
 echo "Vul uw voor en achternaam in";
}
else
{
  echo $_GET["naam"] . " " .$_GET["achternaam"];
}
?>


<br><br>

<h1>Form voor Post</h1>
<form action="" method="post">
  <h3>Wat is een mooie auto?</h3>
  <input type="checkbox" name="BMW" value="BMW">BMW<br>
  <input type="checkbox" name="Audi" value="Audi">Audi<br>
  <input type="checkbox" name="Porsche" value="Porsche">Porsche<br>
  <input type="checkbox" name="Volkswagen" value="Volkswagen">Volkswagen<br>
  <input type="checkbox" name="Fiat" value="Fiat">Fiat<br><br>
  <input type="submit"/><br>
</form>
<br>
<!-- doormiddel van een formulier met checkboxen vul je een waarde in en met een foreach schrijf ik de _POST waarden weg met een echo
Optie 2 is met var_dump te laten zien wat er is aangeklikt. -->


<?php

if (empty($_POST))
{

}
else
{
  echo "<h6>Optie 1</h6>";
  echo "Ik vind: ";
foreach ($_POST as $aangevinkt)
{
  echo  $aangevinkt . ' ';
}
  echo " mooie wagen(s).";

  echo '<h6>Optie 2</h6>';
  var_dump($_POST);
}

?>




  </body>
</html>
