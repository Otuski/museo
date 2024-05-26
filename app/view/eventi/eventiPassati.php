<!doctype html>
<html lang="it">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Eventi Passati</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      body{
        font-family:Palatino;
        background: url("/app/view/museo/charismusBlur.jpg") no-repeat fixed;
      }
      #container{
        position: relative;
      }
      #content{
        background:rgba(67,58,52,0.9) repeat-y fixed; 
      }
      h1{
        text-shadow: 2px 2px 8px black; 
        font-size: 120px; 
      }
      h3{
        font-size:370%; 
        text-shadow: 2px 2px 8px black;
      }
      p{
        font-size: 20px; 
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
      }
      #bttn{
        width:25%;
        font-size: 150%;
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
        width:45%;
        font-size: 120%;
      }
      .btn-light:hover{
        background-color: white;
      }
    </style>
  </head>
  <body class="text-light d-flex flex-column min-vh-100">
    <div id="container" class="container text-center"> 
      <div class="row">
        <div class="col"></div>
        <div id="content" class="col-10">
         <!-- navbar -->
<nav class="navbar ">
          <div class="container-fluid">
            <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
              <span class="navbar-toggler-icon "></span>
            </button>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
              <div class="offcanvas-header">
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
              <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                  <li class="nav-item">
                    <a class="nav-link" href="homepage">Home</a>
                  </li>
                  <li class="nav-item">
                    <hr class="divider">
                  </li>
                  <li class="nav-item">
                  	<?php
                      	if(isset($logged) && $logged){
                          	echo '<a class="nav-link" href="profilo">Profilo</a></li>';
					                  echo '<li class="nav-item">';
							              echo '<a class="nav-link" href="iMieiBiglietti">I Miei Biglietti</a>';
                          }else{
                          	echo '<a class="nav-link" href="login">Login</a>';
                          }
                      ?>
                      </li>
                  <li class="nav-item">
                    <a class="nav-link" href="eventiFuturi">Eventi</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="aboutUs">About Us</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </nav>
        <!-- fine navbar -->

          <div id="center">
            <h1 class="text-center"><b>Eventi Passati</b></h1>
            <div class="d-flex justify-content-end">
              <a href="eventi" id="bttn" class="btn btn-outline-light btn-rounded">Eventi</a>
            </div>
            <br>
            <!-- card evento -->
            <?php
            if ( count($eventi) > 0){
              foreach ($eventi as $evento) {
                echo '<div class="card" style="width: 100%;">';
                echo '<div class="card-body">';
                echo '<div class="row align-items-center">';
                echo '<div class="col">';
                echo '<h5 class="card-title" style="font-size:40px"><b>'. $evento['titolo'] .'</b></h5>';
                echo '<p class="card-text" style="font-size:20px">dal '. $evento['dataInizio'] .' al '.$evento['dataFine'].'</p>';
                echo '</div>';
                echo '<div class="col d-flex justify-content-center">';
                echo '<a href="dettagliEventoPassato/'.$evento['idVisita'].'" class="btn btn-light me-4">Dettagli</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
              }
            }else{
              echo '<h3 class="text-center"><b>Nessun evento disponibile!</b></h3>';
            }

            ?>
            <!-- fine card evento -->
            <br>
          </div>

          <!-- footer -->
          <footer class="footer mt-auto py-3" >
            <!-- grid container -->
            <?php
                if(isset($logged) && $logged){
                    
                    echo '<div class="container p-4 pb-0">
                            <section style="display:flex; justify-content:center; align-items:center;">
                            </section>
                        </div>';
                }else{
                    echo '<div class="container p-4 pb-0">
                            <section style="display:flex; justify-content:center; align-items:center;">
                            <span>Crea il tuo account:</span>
                            <a href="signin" method="post" style="margin-left: 3%;">
                                <button data-mdb-ripple-init type="button" class="btn btn-outline-light btn-rounded">Registrati!</button>
                            </a>
                            </section>
                        </div>';
                
                }
              ?>
            <!-- grid container -->
            <hr class="divider">
            <div class="text-center p-3">
              © 2024 Copyright: Girasole Arancio
            </div>
          </footer>
          <!-- fine footer -->

        </div><!-- fine div centrale-->
        <div class="col"></div>
      </div><!-- fine row -->


    </div><!-- fine container -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
  </body>
</html>

<!-- <!DOCTYPE html>
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
            <a href="biglietti">biglietti</a>
            <br>
            <a href="profilo">Profilo</a>
            <br>
            <a href="eventi">Eventi</a>
            <br>
            <a href="aboutUs">About Us</a>
            <br>
        </nav>

        <a href="eventiFuturi">
            <button>eventiFuturi</button>
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
                    echo '<a href = "dettagliEventoPassato/'.$evento['idVisita'].'">'.'<button>storico</button>'.'</a>';
                    echo '</div>';

                }
            }else{
                echo 'niente eventi';
            } 

            echo var_dump($eventi);
        ?>



    </body>
</html>