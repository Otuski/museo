<!DOCTYPE html>
<html>
    <head>
        <title>modificaPassword</title>
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


        <form action="elaboraModificaPassword" method="post">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="password" required minlength="8">

            <br>

            <input type="submit">

        </form>
        

    </body>
</html>