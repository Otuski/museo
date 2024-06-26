<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biglietti</title>
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
        min-height: 100vh; 
        display: flex;
        flex-direction: column;
      }
      h1{
        text-shadow: 2px 2px 8px black; 
        font-size: 120px; 
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
        width:30%;
        font-size: 180%;
      }
      .btn-light:hover{
        background-color: white;
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
                          echo '<a class="nav-link active" aria-current="page" id="current" href="iMieiBiglietti">I Miei Biglietti</a>';
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
            <h1 class="text-center"><b>I miei biglietti</b></h1>

            <?php 
                if(is_array($biglietti)){
                    $codTransazione = -1;
                    $idBiglietto = -1;
                    $idServizio = -1;
                    foreach($biglietti as $biglietto){

                        if (!($codTransazione == $biglietto["codTransazione"])){ //se c'e un nuovo aquisto
                            $codTransazione = $biglietto["codTransazione"];
                            echo '<div class="card" style="width: 100%;">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title" style="font-size:280%"><b>'.$biglietto["titolo"].'</b></h5>';
                            echo '<h5 class="card-title" style="font-size:160%"><b>valido dal '.$biglietto['dataInizio'].' al '.$biglietto['dataFine'].'</b></h5>';
                            echo '<a href="dettagliEvento/'.$biglietto['idVisita'].'" id="link" class="text-center p-3">Vai all\'evento</a>';
                            echo '<br>';
                        }

                        if(!($idBiglietto == $biglietto['idBiglietto'])){ //se c'e un nuovo biglietto
                            $idBiglietto = $biglietto['idBiglietto'];
                            echo '<div class="row justify-content-center align-items-center">';
                            echo '<div class="col text-center">';
                            echo '<h4>Biglietto '.$biglietto['nomeCategoria'].', € '.$biglietto['prezzo'].' x qta</h4>';
                            echo '</div>';
                            echo '<div class="col text-center">';
                            echo '<h4 class="ms-5">€ tot dei biglietti</h4>';
                            echo '</div>';
                            echo '</div><!-- fine row -->';
                        }

                        if(isset($biglietto['codServizio'])){
                            echo '<div class="row justify-content-center align-items-center">';
                            echo '<div class="col text-center">';
                            echo '<h4>'.$biglietto['nomeServizio'].', € '.$biglietto['prezzoServizio'].' x qta</h4>';
                            echo '</div>';
                            echo '<div class="col text-center">';
                            echo '<h4 class="ms-5">€ tot dei servizi</h4>';
                            echo '</div>';
                            echo '</div><!-- fine row -->';
                        }
                    }
                    echo '<hr>';
                        echo '<div class="row">';
                        echo '<div class="col align-items-center">';
                        echo '<h5 class="card-title" style="font-size:270%"><b>Totale:</b></h5>';
                        echo '</div>';
                        echo '<div class="col text-center d-flex align-items-center">';
                        echo '<h6 style="margin: 0 auto; width:70%; font-size:190%">€ XX.XX</h6>';
                        echo '</div>';
                        echo '</div><!-- fine row -->';
                        echo '</div>';
                        echo '</div><!-- fine card -->';
                        echo '<br>';

                }else{
                    echo '<br><h5 class="card-title" style="font-size:270%"><b>Non hai ancora comprato biglietti</b></h5>';
                    echo '<br><br>';
                    echo '<a href="eventiFuturi" class="btn btn-light btn-lg">Prenota un evento</a>';
                }
            ?>


          </div>

          <!-- footer -->
         <footer class="footer mt-auto py-3" >
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