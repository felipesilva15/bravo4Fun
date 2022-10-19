<?php

  require_once("../config.php");
  //require_once("../class/Produto.php");
  require_once("../class/Sql.php");

  //$produto = new Produto();

  $inventoryValue = 700000;
  $inventoryItens = 1250000;
  $totalProducts = 88;
  $totalUsers = 26;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu</title>
  <link rel="shortcut icon" href="/bravo4Fun/res/images/logo.ico">
  <link rel="stylesheet" href="/bravo4Fun/res/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bravo4Fun/res/css/global.css">
  <link rel="stylesheet" href="../res/css/menu.css">
</head>
<body>
  <header id="header">
    <nav id="nav">
      <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-expanded="false">
        <span id="span"></span>
    </button>
      <ul id="menu">
        <!-- <li><a id="produtomenu" onclick="montarMenu('produtomenu')" href="#">Vendas</a></li> -->
        <li><a  href="../categoriaConsultar.php">Categoria</a></li>
        <li><a  href="../adminConsultar.php">Administrador</a></li>
      </ul>
    </nav>
    <a id="logo" href="/bravo4Fun/views/menu.html">Bravo4 Fun</a>
    <img id="semfoto" src="/bravo4Fun/res/images/semfoto.png" width="50">
  </header>
  <main class="full-height">
    <div class="row g-3 mx-4 my-4">
      <div class="row g-3">
        <div class="col-lg-3 col-md-6 col-12">
          <div class="box p-3 margin-0">
            <h4 class="card-title">Valor de estoque</h4>
            <div class="row g-3 align-items-center p-0">
              <div class="col-4">
                <img src="../res/images/growth.png" alt="" width="70px">
              </div>
              <div class="col-8">
                <h2 class="my-5 pe-2 text-end textNumberCompact textMoneySymbol"><?php echo $inventoryValue ?></h2> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="box p-3 margin-0">
            <h4 class="card-title">Itens em estoque</h4>
            <div class="row g-3 align-items-center">
              <div class="col-4">
                <img src="../res/images/cubes.png" alt="" width="70px">
              </div>
              <div class="col-8">
                <h2 class="my-5 pe-2 text-end textNumberCompact"><?php echo $inventoryItens ?></h2> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="box p-3 margin-0">
            <h4 class="card-title">Produtos</h4>
            <div class="row g-3 align-items-center">
              <div class="col-4">
                <img src="../res/images/trolley.png" alt="" width="70px">
              </div>
              <div class="col-8">
                <h2 class="my-5 pe-2 text-end textNumberCompact"><?php echo $totalProducts ?></h2> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="box p-3 margin-0">
            <h4 class="card-title">Usuários</h4>
            <div class="row g-3 align-items-center">
              <div class="col-4">
                <img src="../res/images/user.png" alt="" width="70px">
              </div>
              <div class="col-8">
                <h2 class="my-5 pe-2 text-end textNumberCompact"><?php echo $totalUsers ?></h2> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 box p-4 margin-0">
          <div class="my-2">
            <h4>Top 10 - Valor de estoque por produto</h4>
          </div>
          <div class="m-2 mt-5 pb-1">
            <div class="mt-4 table-responsive">
              <table class="table table-striped table-hover">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Produto</th>
                    <th>Categoria</th> 
                    <th>Valor Unit.</th>    
                    <th>Qtd. Total</th>
                    <th>Valor total</th>    
                  </tr>    
                </thead>
                <tbody class="table-group-divider">
                  
                </tbody>   
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../res/bootstrap/js/bootstrap.min.js"></script>
  <script src="../res/plugins/jQuery/jquery-3.6.1.min.js"></script>
  <script src="../res/plugins/input/jquery.maskMoney.js"></script>
  <script src="../res/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../res/bootstrap/js/bootstrap.esm.min.js"></script>
  <script src="../res/js/utils.js"></script>
  <script src="../res/js/mask.js"></script>
  <script src="../res/js/modal.js"></script>
  <script src="../res/js/api.js"></script>
  <script src="../res/js/menu.js"></script>
  <script src="../res/js/init.js"></script>
</body>
</html>