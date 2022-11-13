<?php
    require_once("../config.php");
    require_once("../class/Categoria.php");
    require_once("../class/Sql.php");
    
    $categoria = new Categoria();
    
    $categoria->setId(isset($_GET["id"]) ? $_GET["id"] : 0);
    $categoria->loadById();
    
    $acao = isset($_GET["id"]) ? "U" : "C"
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bravo 4 Fun</title>
    <link rel="shortcut icon" href="../res/images/logo.ico">
    <link rel="stylesheet" href="../res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/global.css">
    <link rel="stylesheet" href="/bravo4Fun/res/css/menu.css">
    <link rel="stylesheet" href="/bravo4Fun/res/css/produtoOrdemImagem.css">
</head>
<body class="default-height-body">
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
        <img id="semfoto" src="/bravo4Fun/res/images/semfoto.png" width="50">
    </header>
    <main class="full-height">
        <div class="m-3">
            <div class="box box-dig p-2 margin-0">
                <div class="my-3">
                    <h3>Produto - Imagens e ordem</h3>
                </div>
                <div class="m-2 mt-4">
                    <form id="form-js" action="produtoOrdemImagem.php" method="post" redirect="categoriaConsultar.php">
                        <div class="row g-3">
                            <input name="PRODUTO_ID" required type="hidden" class="form-control" placeholder="" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : 0?>">
                            <div class="box p-3 margin-0">
                                <div class="mb-3">
                                    <h4>Imagens descartadas</h4>
                                </div>
                                <div class="row g-3 column">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 item" draggable="true">
                                        <div class="box margin-0 item-card">
                                            <img draggable="false" class="p-1 item-img" src="/bravo4Fun/res/images/produto-sem-foto.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 item" draggable="true">
                                        <div class="box margin-0 item-card">
                                            <img draggable="false" class="p-1 item-img" src="/bravo4Fun/res/images/produto-sem-foto.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 item" draggable="true">
                                        <div class="box margin-0 item-card">
                                            <img draggable="false" class="p-1 item-img" src="/bravo4Fun/res/images/produto-sem-foto.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2 item" draggable="true">
                                        <div class="box margin-0 item-card">
                                            <img draggable="false" class="p-1 item-img" src="/bravo4Fun/res/images/produto-sem-foto.jpg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2" draggable="true">
                                        <div class="box margin-0 item-add">
                                            <img draggable="false" src="/bravo4Fun/res/images/plus-symbol-button.png" alt="" height="auto" class="plus-button-icon">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="box p-3 margin-0">
                                <div class="mb-3">
                                    <h4>Imagens selecionadas</h4>
                                </div>
                                <div class="row g-3 column">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                                        <div style="aspect-ratio: 9/9;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-success mx-1" id="btnOk">Alterar</button>
                                <a href="../categoriaConsultar.php" class="btn btn-light mx-1">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="../res/bootstrap/js/bootstrap.min.js"></script>
<script src="../res/plugins/jQuery/jquery-3.6.1.min.js"></script>
<script src="../res/plugins/input/jquery.maskMoney.js"></script>
<script src="../res/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../res/js/utils.js"></script>
<script src="../res/js/mask.js"></script>
<script src="../res/js/modal.js"></script>
<script src="../res/js/api.js"></script>
<script src="../res/js/init.js"></script>
<script src="../res/js/forms.js"></script>
<script src="/bravo4Fun/res/js/menu.js"></script>
<script src="/bravo4Fun/res/js/produtoOrdemImagem.js"></script>
</html>