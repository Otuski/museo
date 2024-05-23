<!DOCTYPE html>
<html>
    <head>
        <title>eventiPassati</title>
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

        <a href="eventiPassati">
            <button>eventiPassati</button>
        </a>


        <?php
            if ( count($eventi) > 0){
                foreach ($eventi as $evento) {
                    echo '<br>';
                    echo '<div>';
                    echo 'titolo: '. $evento['titolo'] .'<br>';
                    echo 'descrizione: '. $evento['descrizione'] .'<br>';
                    echo 'tariffa: '. $evento['tariffa'] .'$<br>';
                    echo 'date: '. $evento['dataInizio'] .'  '.$evento['dataFine'].'<br>';
                    echo '<a href = "dettagliEvento/'.$evento['idVisita'].'">'.'<button>pronota</button>'.'</a>';
                    echo '</div>';

                }
            }else{
                echo 'niente eventi';
            } 

           
        ?>



    </body>
</html>