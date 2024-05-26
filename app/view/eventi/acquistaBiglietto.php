<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Acquisto Biglietti</title>
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
        font-size:160%;
      }
      .col-form-label, .form-check-label{
        font-size:120%;
      }
      #quantity{
        width:20%;
      }
      .form-check-input {
        width: 1.5em;
        height: 1.5em;
      }
      #data{
        width:15%;
        position: relative;
        top: 50%;
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
      }
    </style>
  </head>
  <body class="text-light d-flex flex-column min-vh-100">
    <div id="container" class="container text-center"> 
      <div class="row">
        <div class="col"></div>
        <div id="content" class="col-10">
          <div class="col d-flex justify-content-start">
            <a href="dettagliEvento" id="bttn" class="btn btn-outline-light btn-rounded btn-lg">Indietro</a>
          </div>

          <div id="center">
            <h1 class="text-center"><b>Acquisto Biglietti</b></h1>

            <?php
		        echo '<h5 style="font-size:200%"><b>'.$evento['titolo'].'</b></h5><br>';   
                if(isset($_SESSION['error'])){
                    echo ''.$_SESSION['error'].'';
                }else{
                    unset($_SESSION['error']);
                }
            ?>

            <form action="../elaboraAcquistaBiglietto" method="POST">

              <!-- card 00 -->
              <div class="card" style="width: 100%;">
                <div class="card-body">
                  <h5 class="card-title" style="font-size:250%"><b>Data:</b></h5>
                  <br>
                  <input type="date" id="data" name="dataBiglietto">
                </div>
              </div>
              <!-- fine card 00 -->
              <br>
                <!-- card 01 -->
              <div class="card" style="width: 100%;">
                <div class="card-body">
                  <h5 class="card-title" style="font-size:250%"><b>Tipologia biglietti:</b></h5>
                  <?php
                  foreach ($categorie as $categoria) {
                    echo '<hr>';
                    echo '<div class="row d-flex align-items-center">';
                    echo '<div class="col">';
                    echo '<h4 class="text-center">'.$categoria['descrizione'].'</h4>';
                    echo '</div>';
                    echo '<div class="col">';
                    echo '<label for="categoria/'.$categoria['codCategoria'].'" class="col-form-label mb-0" style="font-size:160%">€'.$evento['tariffa']-($evento['tariffa']*$categoria['sconto']).'</label>';
                    echo '<input class="ms-5" type="number" id="quantity" name="categoria/'.$categoria['codCategoria'].'" min="0" max="10"">';
                    echo '</div>';
                    echo '</div><!-- fine row -->';
                    echo 'Documento necessario: '.$categoria['tipoDocumento'].'<br>';
                    echo '<br>';
	            }
                  ?>
                </div><!-- card body -->
              </div>
              <!-- fine card 01 -->
              <br>

            <?php
                foreach ($accessori as $accessorio) {
                    echo '<br>';
	                echo 'descrizione: '.$acessorio['descrizione'].'<br>';
	                echo 'prezzo: '.$acessorio['prezzoAPersona'] . '$<br>';
                    echo '<input type="checkbox" name="accessorio/'.$acessorio['codServizio'].'"><br>';
                    echo '<br>';
                }
                
                
                echo '<input type="hidden" name="idVisita" value='.$evento['idVisita'].'>';

                echo '<br>';

                echo '<input type="submit">';
                
                
                echo '</form>';
                echo '</div>';         
        ?>


            
              
              <!-- card 02 -->
              <div class="card" style="width: 100%;">
                <div class="card-body">
                  <h5 class="card-title" style="font-size:250%"><b>Accessori:</b></h5>
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <h4 class="text-center">Accessorio 1</h4>
                    </div>
                    <div class="col">
                      <label class="form-check-label mb-0 me-5" for="flexCheckDefault">€ XX.XX</label>
                      <input class="form-check-input ms-5" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                  </div>
                  <!-- fine row 1 -->
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <h4 class="text-center">Accessorio 2</h4>
                    </div>
                    <div class="col">
                      <label class="form-check-label mb-0 me-5" for="flexCheckDefault">€ XX.XX</label>
                      <input class="form-check-input ms-5" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                  </div><!-- fine row 2 -->
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <h4 class="text-center">Accessorio 3</h4>
                    </div>
                    <div class="col">
                      <label class="form-check-label mb-0 me-5" for="flexCheckDefault">€ XX.XX</label>
                      <input class="form-check-input ms-5" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                  </div><!-- fine row 3 -->
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <h4 class="text-center">Accessorio 4</h4>
                    </div>
                    <div class="col">
                      <label class="form-check-label mb-0 me-5" for="flexCheckDefault">€ XX.XX</label>
                      <input class="form-check-input ms-5" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                  </div><!-- fine row 4 -->
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <h4 class="text-center">Accessorio 5</h4>
                    </div>
                    <div class="col">
                      <label class="form-check-label mb-0 me-5" for="flexCheckDefault">€ XX.XX</label>
                      <input class="form-check-input ms-5" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                  </div><!-- fine row 5 -->
                </div>
              </div>
              <!-- fine card 02 -->
              <br>
              <input class="btn btn-light btn-lg" type="submit" value="Checkout">
            </form>
          </div><!-- fine #center -->

          <!-- footer -->
          <footer class="footer mt-auto py-3" >
            <!-- grid container -->
            <div class="container p-4 pb-0">
              <section style="display:flex; justify-content:center; align-items:center;">
                <span>Crea il tuo account:</span>
                <a href="signin" method="post" style="margin-left: 3%;">
                  <button data-mdb-ripple-init type="button" class="btn btn-outline-light btn-rounded">Registrati!</button>
                </a>
              </section>
            </div>
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