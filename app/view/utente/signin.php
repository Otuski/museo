<!doctype html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body{
        font-family:Palatino;
        background: url("/app/view/museo/charismusBlur.jpg") no-repeat fixed;
      }
      #container{
        position: relative;
      }
      #content {
        background: rgba(67, 58, 52, 0.9) repeat-y fixed;
        min-height: 100vh; 
      }
      h1{
        text-shadow: 2px 2px 8px black; 
        font-size: 90px; 
      }
      p{
        font-size: 20px; 
        color: rgba(140,121,109,255);
      }
      a.nav-link{
        color:white;
        text-decoration:none;
        font-size: 30px;
      }
      a.nav-link:hover{
        color:rgba(67,58,52,255);
      }
      a.nav-link#current{
        color:rgba(67,58,52,255);
        font-size: 40px;
      }
      .offcanvas {
        background-color: rgba(140,121,109,255);
      }
      .custom-toggler.navbar-toggler{
        border-color: rgba(0,0,0,0);
      }
      .custom-toggler .navbar-toggler-icon{
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='30' height='30' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(140,121,109,255)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        font-size:40px;
      }
      footer{
        color: rgba(140,121,109,255);
        font-size: 18px;
        text-align: center;
      }
      .btn-outline-light{
        color: rgba(140,121,109,255);
        border-color: rgba(140,121,109,255);
      }
      .btn-outline-light:hover{
        color: white;
        border-color: rgba(140,121,109,255);
        background-color: rgba(140,121,109,255);
      }
      #center{
        margin: 0% 10%;  
       padding:10% 0%;
        justify-content: center; /* Center content vertically */
      }
      #bttn{
        width:17%;
        font-size: 160%;
        margin-top: 5%;
        margin-left: 5%;
      }
      .card{
        background-color:rgba(67,58,52,255);
        border-color:rgba(140,121,109,255);
        color:white;
      }
      .btn-light{
        background-color: rgba(140,121,109,255);
        border-color:rgba(140,121,109,255);
        color:white;
        width:30%;
        font-size: 180%;
      }
      .btn-light:hover{
        background-color: white;
      }
      h4{
        font-size:150%;
      }
      .col-form-label{
        font-size:190%;
      }
      .form-check-input {
        width: 1.5em;
        height: 1.5em;
      }
      label{
        display: flex; 
        justify-content: flex-end;
      }
      #field{
        width: 60%;
        display: inline-block;
        float: left;
      }
      #link{
      color: rgba(140,121,109,255);
        font-size: 130%;
        text-align: center;
        text-decoration:none;
        }
        #link:hover{
        color: white;
        }
    </style>
  </head>
  <body class="text-light d-flex flex-column min-vh-100">
    <div id="container" class="container text-center"> 
      <div class="row">
        <div class="col"></div>
        <div id="content" class="col-10">
          <div class="col d-flex justify-content-start">
            <a href="homepage" id="bttn" class="btn btn-outline-light btn-rounded btn-lg">Indietro</a>
          </div>

          <div id="center">
            <h1 class="text-center"><b>Registrati</b></h1>

            <?php
                if(isset($_SESSION['error'])){
                  echo '<!-- card 00 -->
                    <div class="card" style="width: 100%;">
                      <div class="card-body">
                        <h5 class="card-title" style="font-size:250%"><b>Errore:</b></h5>
                        <h5 class="text-center"">'.$_SESSION['error'].'</h5>
                      </div>
                    </div>
                  <!-- fine card 00 -->
                  <br>';
                }
                
                unset($_SESSION['error']);
                
            ?>

            <form action="elaboraSignin" method="POST">
              <!-- card 01 -->
              <div class="card" style="width: 100%;">
                <div class="card-body align-items-center text-center">
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="username" class="col-form-label mb-0">Username:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="text" id="field" name="username" placeholder="username" required><br>
                    </div>
                  </div><!-- fine row username -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="nome" class="col-form-label mb-0">Nome:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="text" id="field" name="nome" placeholder="nome" required><br>
                    </div>
                  </div><!-- fine row nome -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="cognome" class="col-form-label mb-0">Cognome:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="text" id="field" name="cognome" placeholder="cognome" required><br>
                    </div>
                  </div><!-- fine row cognome -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="mail" class="col-form-label mb-0">Email:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="mail" id="field" name="mail" placeholder="mail@exemple.com" required><br>
                    </div>
                  </div><!-- fine row email -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="password" class="col-form-label mb-0">Password:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="password" id="field" name="password" placeholder="password" required minlength="8"><br>
                    </div>
                  </div><!-- fine row password -->
                  
                </div><!-- fine card-body -->
              </div><!-- fine card 01 -->

              <br>
              <input class="btn btn-light btn-lg" type="submit" value="Conferma">
            </form>
            <!-- fine form -->

            <br>
            <a href="login" id="link" class="text-center p-3">Hai già un account?</a>
          </div><!-- fine #center -->

        </div><!-- fine div centrale-->
        <div class="col"></div>
      </div><!-- fine row -->


    </div><!-- fine container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
  </body>
</html>