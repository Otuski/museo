<!DOCTYPE html>
<html>
    <head>
        <title>dettagliEvento</title>
    </head>
    <body>

        <nav>
            <a href="../homepage"> Homepage</a>
            <br> 
            <a href="../login">Login</a>
            <br>
            <a href="../biglietti">biglietti</a>
            <br>
            <a href="../profilo">Profilo</a>
            <br>
            <a href="../eventi">Eventi</a>
            <br>
            <a href="../aboutUs">About Us</a>
            <br>
        </nav>


        <?php
                echo '<br>';
		        echo '<div>';
                echo 'titolo: '. $evento->titolo .'<br>';
                echo 'descrizione: '. $evento->descrizione .'<br>';
                echo 'tariffa: '. $evento->tariffa .'<br>';
                echo '<br>';
                echo 'accessori: <br>';
                echo '<br>';
                foreach ($accessori as $accessorio) {
	                echo ' - descrizione '.$accessorio['descrizione'];
	                echo ' - prezzo '.$accessorio['prezzoAPersona'].'$ <br>';
                }

                echo '<br>';

                echo 'categorie di biglietto: <br>';
                echo '<br>';
                foreach ($categorie as $categoria) {
                    echo ' - descrizione '.$categoria['descrizione'].'<br>';
		            echo ' - sconto: '.($categoria['sconto']*100).'%<br>';
		            echo ' - documento necessario '.$categoria['tipoDocumento'].'<br>'; 
                    echo '<br>';
                    echo '<br>';
                }

                echo '</div>';
        ?>


    </body>
</html>