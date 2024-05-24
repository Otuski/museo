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

        <h1>Profilo</h1>

        <p>Username: <?php echo $user["username"];?> </p>
        <br>

        <p>Nome: <?php echo $user["nome"];?> </p>
        <br>

        <p>Cognome: <?php echo $user["cognome"];?> </p>
        <br>

        <p>Mail: <?php echo $user["mail"];?> </p>
        <br>

        <a href="modificaProfilo">
            <button>Modifica Profilo</button>
        </a>

        <a href="modificaPassword">
            <button>Modifica Password</button>
        </a>
        

    </body>
</html>