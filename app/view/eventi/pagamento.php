<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pagamento</title>
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
        font-size: 90px; 
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
      h6{
        background-color: rgba(140,121,109,255);
        font-size: 170%;
        color:white;
        border-radius: 10px;
        padding: 2%;
        width: 45%;
      }
      h4{
        font-size:150%;
      }
      .btn-light{
        background-color: rgba(140,121,109,255);
        border-color:rgba(140,121,109,255);
        color:white;
        width:30%;
        font-size: 210%;
        padding: 2%;
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
          <div class="col d-flex justify-content-start">
            <?php echo'<a href="dettagliEvento/'.$evento["idVisita"].'" id="bttn" class="btn btn-outline-light btn-rounded btn-lg">Indietro</a>'; ?> 
          </div>

          <div id="center">
            <h1 class="text-center"><b>Riepilogo</b></h1>
            <br>
            <!-- card biglietti -->
            <div class="card" style="width: 100%;">
              <div class="card-body">
                <h5 class="card-title" style="font-size:250%"><b>Biglietti:</b></h5>
                <?php
                  $totale = 0;

                  foreach ($categorie as $CategoriaDisponibile) {
                      
                      foreach ($categorieScelte as $CategoriaScelta) {

                          if( isset($CategoriaDisponibile["codCategoria"], $CategoriaScelta["codCategoria"]) 
                              && $CategoriaDisponibile["codCategoria"] == $CategoriaScelta["codCategoria"]
                              && $CategoriaScelta["qta"] > 0){
                              echo '<div class="row justify-content-center align-items-center">';
                              echo '<div class="col text-center">';
                              $prezzo = $evento["tariffa"] - $evento["tariffa"] * $CategoriaDisponibile["sconto"];
                              echo '<h4>Biglietto, '.$CategoriaDisponibile["descrizione"].' €'.$prezzo.' x '.$CategoriaScelta["qta"].' </h4>';
                              echo '</div>';
                              echo '<div class="col text-center">';
                              echo '<h6 class="ms-5">€ '.$prezzo*$CategoriaScelta["qta"].'</h6>';
                              echo '</div>';
                              echo '</div><!-- fine row -->';
                              echo '<br>';
                              $totale+= (float)$prezzo*$CategoriaScelta["qta"];
                          }
                          
                      }

                  }
                ?>
              </div>
            </div>
            <!-- fine card biglietti -->
            <br>
            <!-- card servizi -->
            <div class="card" style="width: 100%;">
              <div class="card-body">
                <h5 class="card-title" style="font-size:250%"><b>Accessori:</b></h5>
                <?php           
                    foreach ($accessori as $accessorioDisponibile) {

                        foreach ($accessoriScelti as $accessorioScelto) {
                          if(isset($accessorioScelto["codServizio"], $accessorioDisponibile["codServizio"]) 
                          && $accessorioScelto["codServizio"] == $accessorioDisponibile["codServizio"]){
                            echo '<div class="row justify-content-center align-items-center">';
                            echo '<div class="col text-center">';
                            $prezzo = $accessorioDisponibile["prezzoAPersona"];
                            echo '<h4>Accessorio, '.$accessorioDisponibile["descrizione"].' € '.$prezzo.'</h4>';
                            echo '</div>';
                            echo '<div class="col text-center">';
                            echo '<h6 class="ms-5">€'.$prezzo.'</h6>';
                            echo '</div>';
                            echo '</div><!-- fine row -->';
                            echo '<br>';
                            $totale+=(float)$prezzo;
                          }
                        }
                  }


                  
                ?>
              </div>
            </div>
            <!-- fine card servizi  -->
            <br>
            <!-- card totale -->
            <div class="card" style="width: 100%;">
              <div class="card-body">
              <div class="row">
                  <div class="col align-items-center">
                    <h5 class="card-title" style="font-size:270%"><b>Totale:</b></h5>
                  </div>
                  <div class="col text-center d-flex align-items-center">
                    <h6 style="margin: 0 auto; width:70%; font-size:190%"><?php echo "€ $totale"; ?></h6>
                  </div>
                </div><!-- fine row -->
              </div>
            </div>
            <!-- fine card totale -->
            <br><br>
            <a href="#" class="btn btn-light btn-lg">Checkout</a>

          </div><!-- fine #center -->

          <!-- footer -->
         <footer class="footer mt-auto py-3" >
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