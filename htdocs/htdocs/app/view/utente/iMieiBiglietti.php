<!DOCTYPE html>
<html>
    <head>
        <title>Profilo</title>
    </head>
    <body>

        <nav>
            <a href="homepage"> Homepage</a>
            <br> 
            <a href="login">Login</a>
            <br>
            <a href="iMieiBiglietti">iMieiBiglietti</a>
            <br>
            <a href="profilo">Profilo</a>
            <br>
            <a href="eventi">Eventi</a>
            <br>
            <a href="aboutUs">About Us</a>
            <br>
        </nav>

        <br>

        <h1>iMieiBiglietti</h1>

        <p>Username: <?php echo $user -> username;?> </p>
        <br>

        <?php 

            

            var_dump($biglietti);

            if(is_array($biglietti)){
                $codTransazione = -1;
                $idBiglietto = -1;
                $idServizio = -1;
                foreach($biglietti as $biglietto){

                    if (!($codTransazione == $biglietto["codTransazione"])){ //se c'e un nuovo aquisto
                        $codTransazione = $biglietto["codTransazione"];
                        echo '<br>';
                        echo '<br>';
                        echo "evento: ".$biglietto["titolo"];
                        echo '<br>';
                        echo '<a href="dettagliEvento/'.$biglietto['idVisita'].'">Vai all\'evento</a>';
                        echo '<br>';
                        echo 'Data Validità: <br>';
                        echo 'Inizio: '.$biglietto['dataInizio'].'  Fine: '.$biglietto['dataFine'];
                    }
                    

                    if(!($idBiglietto == $biglietto['idBiglietto'])){ //se c'e un nuovo biglietto
                        $idBiglietto = $biglietto['idBiglietto'];
                        echo '<br>';
                        echo '<br>';
                        echo '- Biglietto nr. '.$biglietto['idBiglietto'].' €'.$biglietto['prezzo'].' '.$biglietto['nomeCategoria'];

                    }

                    if(isset($biglietto['codServizio'])){
                        echo '<br>';
                        echo ' ->'.' €'.$biglietto['prezzoServizio'].' '.$biglietto['nomeServizio'];
                    }

                    

                    //echo '<br>idBiglietto = '.$idBiglietto.'<br> id da query '.$biglietto['idBiglietto'].'<br>';

                }

            }else{
                echo "non hai ancora comprato biglietti";
            }
        ?>
        

    </body>
</html>