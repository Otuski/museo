<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
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

        <h1>Login</h1>


        <?php
            if(isset($_SESSION['error'])){
                echo 'errore: '.$_SESSION['error'];
            }
            session_destroy();
        ?>
        <form action="elaboraLogin" method="post">


            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="username" required minlength="6">

            <br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" required minlength="8">

            <br>

            <input type="submit">

        </form>

        <br>
        <a href = "signin">
            <button >Non sei registrato? Fallo qui!</button>
        </a>
        

    </body>
</html>