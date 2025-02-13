<?php
    //Käynnistetään sessio, johon talletetaan käyttäjä, jos kirjautuminen onnistuu
    session_start();
    require('db.php');

    $uname = filter_input(INPUT_POST, "username");
    $pw = filter_input(INPUT_POST, "password");

    //Tarkistetaan onko muttujia asetettu
    if( !isset($uname) || !isset($pw) ){
        echo "Parametreja puuttui!! Ei voida kirjautua.";
        exit;
    }

    //Tarkistetaan, ettei tyhjiä arvoja muuttujissa
    if( empty($uname) || empty($pw) ){
        echo "Et voi asettaa tyhjiä arvoja!!";
        exit;
    }

    try{
        //Haetaan käyttäjä annetulla käyttäjänimellä
        $sql = "SELECT * FROM person WHERE username=?";
        $statement = $pdo->prepare($sql);
        $statement->bindParam(1, $uname);
        $statement->execute();

        if($statement->rowCount() <=0){
            echo "Käyttäjää ei löydy!!";
            exit;
        }
    
        $row = $statement->fetch();

        //Tarkistetaan käyttäjän antama salasana tietokannan salasanaa vasten
        if(!password_verify($pw, $row["password"] )){
            echo "Väärä salasana!!";
            exit;
        }

        //Jos käyttäjä tunnistettu, talletetaan käyttäjän tiedot sessioon
        $_SESSION["username"] = $uname;
        $_SESSION["fname"] = $row["firstname"];
        $_SESSION["lname"] = $row["lastname"];

        //Ohjataan takaisin etusivulle
        header("Location: ../../public/index.php"); 

    }catch(PDOException $e){
        echo "Kirjautuminen ei onnistunut<br>";
        echo $e->getMessage();
    }

?>