<?php

  // TODO: Adicionar a lógica e funções na classe de produtos
  require_once("../config.php");
  require_once("../class/Sql.php");

  $sql = new Sql();

  // Carrega dados dos cards de produtos
  $dataProducts = $sql->select("SELECT
                          COUNT(1) AS QT_PRODUTOS,
                          SUM(COALESCE(PRO.PRODUTO_PRECO, 0) * COALESCE(EST.PRODUTO_QTD, 0)) AS VL_PRECOTOTAL,
                          SUM(COALESCE(EST.PRODUTO_QTD, 0)) AS QT_ESTOQUETOTAL
                        FROM PRODUTO AS PRO
                        LEFT JOIN PRODUTO_ESTOQUE AS EST ON PRO.PRODUTO_ID = EST.PRODUTO_ID
                        WHERE
                          COALESCE(PRO.PRODUTO_ATIVO, 1) = 1");

  // Carrega dados dos cards de usuários
  $dataAdmins = $sql->select("SELECT 
                                COUNT(1) AS QT_ADMINS 
                              FROM ADMINISTRADOR ADM 
                              WHERE 
                                COALESCE(ADM.ADM_ATIVO, 1) = 1");
                        
  $dataTopProducts = $sql->select("SELECT
                                    COALESCE(PRO.PRODUTO_ID, 0) AS ID,
                                    COALESCE(PRO.PRODUTO_NOME, '') AS DS_PRODUTO,
                                    COALESCE(CAT.CATEGORIA_NOME, '') AS DS_CATEGORIA,
                                    COALESCE(PRO.PRODUTO_PRECO, 0) AS VL_PREUNI,
                                    SUM(COALESCE(PRO.PRODUTO_PRECO, 0) * COALESCE(EST.PRODUTO_QTD, 0)) AS VL_PRECOTOTAL,
                                    SUM(COALESCE(EST.PRODUTO_QTD, 0)) AS QT_ESTOQUETOTAL
                                  FROM PRODUTO AS PRO
                                  LEFT JOIN CATEGORIA CAT ON PRO.CATEGORIA_ID = CAT.CATEGORIA_ID
                                  LEFT JOIN PRODUTO_ESTOQUE AS EST ON PRO.PRODUTO_ID = EST.PRODUTO_ID 
                                  WHERE
                                    COALESCE(PRO.PRODUTO_ATIVO, 1) = 1
                                  GROUP BY
                                    COALESCE(PRO.PRODUTO_ID, 0),
                                    COALESCE(PRO.PRODUTO_NOME, ''),
                                    COALESCE(CAT.CATEGORIA_NOME, ''),
                                    COALESCE(PRO.PRODUTO_PRECO, 0)
                                  ORDER BY
                                    SUM(COALESCE(PRO.PRODUTO_PRECO, 0) * COALESCE(EST.PRODUTO_QTD, 0)) DESC,
                                    SUM(COALESCE(EST.PRODUTO_QTD, 0)) DESC
                                  LIMIT 10");

  $dataProductPerCategory = $sql->select("SELECT
                                    COALESCE(CAT.CATEGORIA_ID, 0) AS FK_CATEGORIA,
                                    COALESCE(CAT.CATEGORIA_NOME, '') AS DS_CATEGORIA,
                                    COUNT(1) AS QT_PRODUTO
                                  FROM PRODUTO PRO
                                  LEFT JOIN CATEGORIA CAT ON PRO.CATEGORIA_ID = CAT.CATEGORIA_ID
                                  WHERE
                                    COALESCE(PRO.PRODUTO_ATIVO, 1) = 1
                                  GROUP BY
                                    COALESCE(CATEGORIA_ID, 0),
                                    COALESCE(CAT.CATEGORIA_NOME, '')
                                  ORDER BY
                                    COUNT(1) DESC
                                  LIMIT 5");

  $dataStorePerCategory = $sql->select("SELECT
                                        COALESCE(CAT.CATEGORIA_ID, 0) AS FK_CATEGORIA,
                                        COALESCE(CAT.CATEGORIA_NOME, '') AS DS_CATEGORIA,
                                        SUM(COALESCE(EST.PRODUTO_QTD, 0)) AS QT_ESTOQUE
                                      FROM CATEGORIA CAT 
                                      LEFT JOIN PRODUTO PRO ON PRO.CATEGORIA_ID = CAT.CATEGORIA_ID
                                      LEFT JOIN PRODUTO_ESTOQUE AS EST ON PRO.PRODUTO_ID = EST.PRODUTO_ID
                                      WHERE
                                        COALESCE(PRO.PRODUTO_ATIVO, 1) = 1
                                      GROUP BY
                                        COALESCE(CATEGORIA_ID, 0),
                                        COALESCE(CAT.CATEGORIA_NOME, '')
                                      ORDER BY
                                        SUM(COALESCE(EST.PRODUTO_QTD, 0)) DESC
                                      LIMIT 10");
                            
  $categoryNameArray = [];
  $categoryValueArray = [];

  foreach ($dataProductPerCategory as $data) {
    array_push($categoryNameArray, $data["DS_CATEGORIA"]);
    array_push($categoryValueArray, $data["QT_PRODUTO"]);
  }

  $storeNameArray = [];
  $storeValueArray = [];

  foreach ($dataStorePerCategory as $data) {
    array_push($storeNameArray, $data["DS_CATEGORIA"]);
    array_push($storeValueArray, $data["QT_ESTOQUE"]);
  }

  $dataProducts = $dataProducts[0];
  $dataAdmins = $dataAdmins[0];
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
                <li><a  href="../produtoConsultar.php">Produto</a></li>
                <li><a  href="../categoriaConsultar.php">Categoria</a></li>
                <li><a  href="../adminConsultar.php">Administrador</a></li>
            </ul>
        </nav>
        <a id="logo" href="/bravo4Fun/views/menu.php">Bravo4 Fun</a>
         <div class="dropdown">
            <a id="btndrop btndrop-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-expanded="false">    
                    <img id="semfoto" src="../res/images/semfoto.png" width="50">
                </button>
            </a>
            <ul id="dropdown-menu" class="dropdown-menu pb-3 pt-3">
                <li><a  href="views/meuPerfil.php">Meu Perfil</a></li>
                <li><a href="#" onclick="logout()">Logout</a></li>
            </ul>
        </div>
  </header>
  <main class="full-height">
    <div class="row g-3 mx-4 my-4">
      <div class="row g-3">
        <div class="col-lg-3 col-md-6 col-12">
          <div class="box p-3 margin-0">
            <h4 class="card-title">Valor do estoque</h4>
            <div class="row g-3 align-items-center p-0">
              <div class="col-4">
                <img src="../res/images/growth.png" alt="" width="70px">
              </div>
              <div class="col-8">
                <h2 class="my-5 pe-2 text-end textNumberCompact textMoneySymbol"><?php echo isset($dataProducts["VL_PRECOTOTAL"]) ? $dataProducts["VL_PRECOTOTAL"] ?? 0 : 0 ?></h2> 
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
                <h2 class="my-5 pe-2 text-end textNumberCompact"><?php echo isset($dataProducts["QT_ESTOQUETOTAL"]) ? $dataProducts["QT_ESTOQUETOTAL"] ?? 0 : 0 ?></h2> 
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
                <h2 class="my-5 pe-2 text-end textNumberCompact"><?php echo isset($dataProducts["QT_PRODUTOS"]) ? $dataProducts["QT_PRODUTOS"] ?? 0 : 0 ?></h2> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-12">
          <div class="box p-3 margin-0">
            <h4 class="card-title">Administradores</h4>
            <div class="row g-3 align-items-center">
              <div class="col-4">
                <img src="../res/images/user.png" alt="" width="70px">
              </div>
              <div class="col-8">
                <h2 class="my-5 pe-2 text-end textNumberCompact"><?php echo isset($dataAdmins["QT_ADMINS"]) ? $dataAdmins["QT_ADMINS"] : 0 ?></h2> 
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="box p-4 margin-0" style="height: 650px">
            <div class="my-2">
              <h4>Estoque por categoria de produto</h4>
            </div>
            <div class="full-height d-flex justify-content-center align-items-center">
              <div class="m-5 mt-5 pb-1" style="min-width: 95%; max-width: 1000px;">
                <canvas id="storePerProductChart" width="82" height="50"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-lg-6">
          <div class="box p-4 margin-0" style="height: 650px">
            <div class="my-2">
              <h4>Quantidade de produtos por categoria</h4>
            </div>
            <div class="full-height d-flex justify-content-center align-items-center">
              <div class="m-5 mt-5 pb-1" style="min-width: 450px; max-width: 600px;">
                <canvas id="productsPerCategoryChart" width="50" height="50"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="box p-4 margin-0">
            <div class="my-2">
              <h4>Top 10 - Valor de estoque por produto</h4>
            </div>
            <div class="m-2 mt-5 pb-1">
              <div class="mt-4 table-responsive">
                <table class="table table-striped table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Produto</th>
                      <th>Categoria</th> 
                      <th>Valor unit.</th>    
                      <th>Valor total</th>   
                      <th>Qtd. Total</th> 
                    </tr>    
                  </thead>
                  <tbody class="table-group-divider">
                    <?php
        
                      foreach ($dataTopProducts as $row) {
                        echo "
                        <tr>
                          <td>{$row["ID"]}</td>
                          <td>{$row["DS_PRODUTO"]}</td>
                          <td>{$row["DS_CATEGORIA"]}</td>
                          <td class=\"textNumber textMoneySymbol\">{$row["VL_PREUNI"]}</td>
                          <td class=\"textNumber textMoneySymbol\">{$row["VL_PRECOTOTAL"]}</td>
                          <td class=\"textNumber\">{$row["QT_ESTOQUETOTAL"]}</td>
                        </tr>
                        ";
                      }

                    ?>
                  </tbody>   
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="../node_modules/chart.js/dist/chart.min.js"></script>
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
  <script src="res/js/logout.js"></script>
  <script>
    const ctx1 = document.getElementById('productsPerCategoryChart').getContext('2d');
    const productsPerCategoryChart = new Chart(ctx1, {
      type: 'doughnut',
      data: {
      labels: <?php echo json_encode($categoryNameArray); ?>,
      datasets: [{
        label: 'Gráfico',
        data: <?php echo json_encode($categoryValueArray); ?>,
        backgroundColor: [
          '#C42A2A',
          '#0F3D3E',
          '#126E82'
        ],
        hoverOffset: 6
      }]
    },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          title: {
            display: false,
            text: 'Chart.js Doughnut Chart'
          }
        }
      },
    });

    const ctx2 = document.getElementById('storePerProductChart').getContext('2d');
    const storePerProductChart = new Chart(ctx2, {
      type: 'bar',
      data: {
      labels: <?php echo json_encode($storeNameArray); ?>,
      datasets: [{
        label: 'Estoque',
        data: <?php echo json_encode($storeValueArray); ?>,
        backgroundColor: [
          '#C42A2A',
          '#0F3D3E',
          '#126E82'
        ],
        borderWidth: 1,
        barPercentage: 1,
        minBarLegth: 2
      }]
    },
    options: {
      scales: {
      y: {
        beginAtZero: false
      }
    },
    responsive: true,
    plugins: {
      legend: {
        position: 'none',
      },
      title: {
        display: false,
        text: 'Chart.js Horizontal Bar Chart'
      }
    }
  },
    });
  </script>
</body>
</html>