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
                    <h3>Categoria - <?php echo $acao == "C" ? "Incluir" : "Alterar" ?></h3>
                </div>
                <div class="m-2 mt-4">
                    <form id="form-js" action="<?php echo $acao == "C" ? "categoriaIncluir.php" : "categoriaAlterar.php" ?>" method="post" redirect="categoriaConsultar.php">
                        <div class="row g-3">
                            <input name="CATEGORIA_ID" required type="hidden" class="form-control" placeholder="" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : 0?>">
                            <div class="col-md-12">
                                <label class="form-label-custom" for="CATEGORIA_NOME">Nome<span class="required">*</span></label>
                                <input name="CATEGORIA_NOME" maxlength="500" required type="text" class="form-control" placeholder="Digite..." value="<?php echo $categoria->getNome() ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label-custom" for="CATEGORIA_DESC">Descrição<span class="required">*</span></label>
                                <textarea name="CATEGORIA_DESC" maxlength="500" rows="6" required type="text" class="form-control" placeholder="Digite..."><?php echo $categoria->getDescricao() ?></textarea>
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-success mx-1" id="btnOk"><?php echo $acao == "C" ? "Cadastrar" : "Alterar" ?></button>
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
</html>