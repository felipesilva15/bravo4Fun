<?php
    require_once("../config.php");
    require_once("../class/produto.php");
    require_once("../class/Categoria.php");
    require_once("../class/Sql.php");
    
    $produto = new Produto();
    $categorias = new Categoria();
    $categorias = $categorias->getCategorias();

    $produto->setId(isset($_GET["id"]) ? $_GET["id"] : 0);
    $produto->loadById();
   
    $acao = isset($_GET["id"]) ? "U" : "C";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bravo 4 Fun</title>
    <link rel="shortcut icon" href="/bravo4Fun/res/images/logo.ico">
    <link rel="stylesheet" href="/bravo4Fun/res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/bravo4Fun/res/css/global.css">
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
                    <h3>Produto - <?php echo $acao == "C" ? "Incluir" : "Alterar" ?></h3>
                </div>
                <div class="m-2 mt-4">
                    <form id="form-js" action="<?php echo $acao == "C" ? "produtoIncluir.php" : "produtoAlterar.php" ?>" method="post" redirect="produtoConsultar.php">                    
                        <div class="row g-3">
                            <input name="PRODUTO_ID" required type="hidden" class="form-control" placeholder="" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>">
                            <div class="col-md-6">
                                <label class="form-label-custom" for="PRODUTO_NOME">Nome<span class="required">*</span></label>
                                <input name="PRODUTO_NOME" maxlength="500" required type="text" class="form-control" placeholder="Digite..." value="<?php echo $produto->getNome()?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom" for="CATEGORIA_ID">Categoria<span class="required">*</span></label>
                                <select class="form-select" aria-label="Default select example" name="CATEGORIA_ID">
                                <option value=0>Selecione...</option>
                                    <?php
                                        $categoriaID = $produto->getCategoria();
                                        foreach ($categorias as $categoria) {
                                            if ($categoriaID == $categoria["CATEGORIA_ID"]) {
                                                echo '<option selected="selected" value="'.$categoria["CATEGORIA_ID"].'">'.$categoria["CATEGORIA_NOME"]. '</option>';    
                                            } else {
                                                echo '<option value="'.$categoria["CATEGORIA_ID"].'">'.$categoria["CATEGORIA_NOME"]. '</option>';    
                                            }                                                                                        
                                        }
                                    ?>                                    
                                </select>                                                                                                                                 
                            </div>    
                            <div class="col-md-6">
                                <label class="form-label-custom" for="PRODUTO_PRECO">Preço<span class="required">*</span></label>
                                <input name="PRODUTO_PRECO" maxlength="6" required type="text" class="form-control inputNumber" placeholder="Digite..." value="<?php echo $produto->getPreco() ?>">
                            </div>                
                            <div class="col-md-6">
                                <label class="form-label-custom" for="PRODUTO_DESCONTO">Desconto<span></span></label>
                                <input name="PRODUTO_DESCONTO" maxlength="6" type="text" class="form-control inputNumber" placeholder="Digite..." value="<?php echo $produto->getDesconto() ?>" >
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom" for="PRODUTO_DESC">Descrição<span></span></label>
                                <textarea name="PRODUTO_DESC" maxlength="500" rows="4" type="text" class="form-control" placeholder="Digite..." value="teste" ><?php echo $produto->getDesc() ?></textarea>
                                <textarea name="PRODUTO_DESC" maxlength="500" rows="4" type="text" class="form-control" placeholder="Digite..." value="" ><?php echo $produto->getDescricao()?></textarea>
                            </div>                                        
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-success mx-1" id="btnOk"><?php echo $acao == "C" ? "Cadastrar" : "Alterar" ?></button>
                                <a href="../produtoConsultar.php" class="btn btn-light mx-1">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="/bravo4Fun/res/bootstrap/js/bootstrap.min.js"></script>
<script src="/bravo4Fun/res/plugins/jQuery/jquery-3.6.1.min.js"></script>
<script src="/bravo4Fun/res/plugins/input/jquery.maskMoney.js"></script>
<script src="/bravo4Fun/res/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/bravo4Fun/res/js/utils.js"></script>
<script src="/bravo4Fun/res/js/mask.js"></script>
<script src="/bravo4Fun/res/js/modal.js"></script>
<script src="/bravo4Fun/res/js/api.js"></script>
<script src="/bravo4Fun/res/js/forms.js"></script>
<script src="/bravo4Fun/res/js/init.js"></script>
<script src="/bravo4Fun/res/js/menu.js"></script>
</html>