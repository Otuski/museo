<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inserisci carta</title>
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
      #fieldSPECIAL{
        width: 30%;
        display: inline-block;
        float: left;
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
            <h1 class="text-center"><b>Pagamento</b></h1>
            <br>
            <form action="#" method="POST">
              <!-- card 01 -->
              <div class="card" style="width: 100%;">
                <div class="card-body align-items-center text-center">
                  <h5 class="card-title" style="font-size:250%"><b>Inserisci i dati della carta</b></h5>
                  <br>
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="nome" class="col-form-label mb-0">Nome:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="textfield" id="field" name="nome"><br>
                    </div>
                  </div><!-- fine row nome -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="cognome" class="col-form-label mb-0">Cognome:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="textfield" id="field" name="cognome"><br>
                    </div>
                  </div><!-- fine row cognome -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="numCarta" class="col-form-label mb-0">Numero di carta:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="tel" id="field" name="numCarta" inputmode="numeric" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" placeholder="xxxx xxxx xxxx xxxx"><br>
                    </div>
                  </div><!-- fine row numCarta -->
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="dataScadenza" class="col-form-label mb-0">Data di scadenza:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" type="month" id="fieldSPECIAL" name="dataScadenza"><br>
                    </div>
                  </div><!-- fine row scadenza -->   
                  <div class="row d-flex align-items-center">
                    <div class="col">
                      <label for="cvv" class="col-form-label mb-0">CVV:</label>
                    </div>
                    <div class="col">
                      <input class="ms-5" id="fieldSPECIAL" type="number" max="999" pattern="([0-9]|[0-9]|[0-9])" name="cvv"/>
                    </div>
                  </div><!-- fine row cvv -->
                </div><!-- fine card-body -->
              </div><!-- fine card 01 -->

              <br>
              <input class="btn btn-light btn-lg" type="submit" value="Checkout">
            </form>
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