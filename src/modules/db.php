<?php
//require 'config.php';

//Tässä haetaan tiedot init-tiedostosta. 
//Voit käyttää myös ylempänä olevaa config.php tiedostoa
//jos haluat. Kommentoi silloin seuraavat rivit.

//Vaihda work tilalle oma juurikansio (localhost/work/....)
//Suora relatiivinen polku kuten ../config/conf.ini ei toimi
//koska tämä sijainti riippuu siitä mihin selaimelta kutsuttuun 
//sijaintiin db.php on kytketty (kuten esim. public/people.php tai scr/modules/add_worktime.php)
$init = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/tietokantaohjelmointi2022/myconf.ini");
$host = $init["host"];
$db = $init["db"];
$user = $init["username"];
$password = $init["pw"];

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
try {
	$pdo = new PDO($dsn, $user, $password);
    //echo "Connected!";
} catch (PDOException $e) {
	echo $e->getMessage();
}
