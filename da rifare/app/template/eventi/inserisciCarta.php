<!DOCTYPE html>
<html>
    <head>
        <title>InserisciCarta</title>
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

        <h1>InserisciCarta</h1>

        <h2>Biglietti</h2>
        <?php 
            
            var_dump($_SESSION);
            echo "<br><br>";

            echo "evento:".$_SESSION['evento']['evento']->titolo ;

            $tariffa = $_SESSION['evento']['evento']->tariffa;
            $sconto = $_SESSION['evento']['categorie'][0]['sconto'];
            
            foreach($_SESSION["CategorieAcquistate"] as $key => $value) {
                $numBiglietti = $value;
                //while($numBiglietti != 1) {echo"";}
                $sconto = $_SESSION['evento']['categorie'][0]['sconto'];
                echo "categoria: ". $tariffa-$tariffa*$sconto."" ;
            }
        ?>

        
        

    </body>
</html>