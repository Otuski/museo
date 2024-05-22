<!DOCTYPE html>
<html>
    <head>
        <title>acquistaBiglietto</title>
    </head>
    <body>

        <nav>
            <a href="homepage"> Homepage</a>
            <br> 
            <a href="login">Login</a>
            <br>
            <a href="biglietti">biglietti</a>
            <br>
            <a href="profilo">Profilo</a>
            <br>
            <a href="eventi">Eventi</a>
            <br>
            <a href="aboutUs">About Us</a>
            <br>
        </nav>


        <?php
		        echo '<div>';
                echo 'titolo:'. $evento->titolo .'<br>';
                echo 'descrizione:'. $evento->descrizione .'<br>';
                echo 'tariffa: '. $evento->tariffa .'$<br>';
                
                echo '<form action="elaboraAcquistaBiglietto" method="POST">';


                foreach ($accessori as $acessorio) {
                    echo '<br>';
	                echo 'descrizione: '.$acessorio['descrizione'].'<br>';
	                echo 'prezzo: '.$acessorio['prezzoAPersona'] . '$<br>';
                    echo '<input type="checkbox" name="accessorio/'.$acessorio['codServizio'].'"><br>';
                    echo '<br>';
                }
                
                foreach ($categorie as $categoria) {
                    echo 'tipo di documento'.$categoria['tipoDocumento'].'<br>';
                    echo 'sconto: '.$categoria['sconto']*100 .'%<br>';
                    echo 'descrizione'.$categoria['descrizione'].'<br>';
                    
                    echo '<input type="number" name="categoria/'.$categoria['codCategoria'].'" min="0" max="10"">';
	            }

                echo '<br>';

                echo '<input type="submit">';
                
                
                echo '</form>';
                echo '</div>';

                
                
        ?>


    </body>
</html>