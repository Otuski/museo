<!DOCTYPE html>
<html>
    <head>
        <title>modificaProfilo</title>
    </head>
    <body>

        <nav>
            <a href="homepage"> Homepage</a>
            <br> 
            <a href="login">Login</a>
            <br>
            <a href="iMieiBiglietti">bigiMieiBigliettilietti</a>
            <br>
            <a href="profilo">Profilo</a>
            <br>
            <a href="eventi">Eventi</a>
            <br>
            <a href="aboutUs">About Us</a>
            <br>
        </nav>

        <br>

        <h1>modificaProfilo</h1>

        <h2> <?php echo $user -> username;?> </h2>
        

        <form action="elaboraModificaProfilo" method="post">


            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="nome" required minlength="8">

            <br>

            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" placeholder="cognome" required minlength="8">

            <br>
            
            <label for="mail">Mail:</label>
            <input type="mail" id="mail" name="mail" placeholder="mail@exemple.com" required minlength="8">

            <br>

            <input type="submit">

        </form>
        

    </body>
</html>