<?php
require_once 'connec.php';
require_once 'Character.php';
require_once 'Database.php';
$pdo = new Database(DSN, USER, PASS);

$perceval = new Character('Perceval', 'Humain', $pdo);
$mirouf = new Character('Mirouf', 'Elfe', $pdo);
$nirouf = new Character('Nirouf', 'Nain', $pdo);
$squirk = new Character('Squirk', 'Gobelin', $pdo);


echo $perceval->showCharacter();
echo "<br>";
echo $mirouf->showCharacter();
echo "<br>";
echo $nirouf->showCharacter();
echo "<br>";
echo $squirk->showCharacter();
echo"<br>";
echo $perceval->attack($mirouf);
echo"<br>";
echo $perceval->attack($mirouf);
echo"<br>";
echo $perceval->attack($mirouf);
echo"<br>";
echo $perceval->attack($mirouf);
echo"<br>";
echo $perceval->attack($mirouf);
echo"<br>";
echo $perceval->attack($mirouf);
echo"<br>";
echo $perceval->attack($mirouf);
echo "<br>";
echo $mirouf->showCharacter();




