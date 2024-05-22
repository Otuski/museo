<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Signin</title>
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

        <h1>Signin</h1>

        <?php
            if(isset($_SESSION['user'])){
                echo 'errore: '.$_SESSION['user']-> error;
            }
        ?>

        <form action="elaboraSignin" method="post">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="username" required minlength="6">

            <br>

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" placeholder="nome" required minlength="8">

            <br>

            <label for="cognome">Cognome:</label>
            <input type="text" id="cognome" name="cognome" placeholder="cognome" required minlength="8">

            <br>
            
            <label for="mail">Mail:</label>
            <input type="mail" id="mail" name="mail" placeholder="mail@exemple.com" required minlength="8">

            <br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" required minlength="8">

            <br>

            <input type="submit">

        </form>
        

    </body>
</html>