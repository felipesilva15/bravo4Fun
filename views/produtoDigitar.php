<?php
    require_once("../config.php");
    require_once("../class/Sql.php");
    require_once("../class/ProdutoEstoque.php");
    require_once("../class/Produto.php");
    
    $produto = new Produto();
    $estoque = new ProdutoEstoque();

    $produto->setId(isset($_GET["id"]) ? $_GET["id"] : 0);
    $produto->loadById();

    $estoque->setProduto(isset($_GET["id"]) ? $_GET["id"] : 0);
    $estoque->loadByProduto();
   
    $acao = isset($_GET["id"]) ? "U" : "C";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bravo 4 Fun</title>
    <link rel="shortcut icon" href="/res/images/logo.ico">
    <link rel="stylesheet" href="/res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/res/css/global.css">
    <link rel="stylesheet" href="/res/css/menu.css">
    <link rel="stylesheet" href="/node_modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="/res/css/fixSelect2Theme.css">
</head>
<body class="default-height-body">
    <?php
        include_once("header.php");
    ?>
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
                            <div class="col-12">
                                <label class="form-label-custom" for="PRODUTO_NOME">Nome <span class="required">*</span></label>
                                <input name="PRODUTO_NOME" maxlength="500" required type="text" class="form-control" placeholder="Digite..." value="<?php echo $produto->getNome()?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label-custom" for="CATEGORIA_ID">Categoria <span class="required">*</span></label>
                                <select class="form-select select2AutoConfig" select2Config="CATEGORIA" select2ValueToSelect="<?php echo $produto->getCategoria()?>" name="CATEGORIA_ID">
                                    <option value="0"></option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label-custom" for="PRODUTO_QTD">Qtd. em estoque</label>
                                <input name="PRODUTO_QTD" min="0" type="text" class="form-control inputNumber" decimalPlaces="0" placeholder="Digite..." value="<?php  echo $estoque->getQuantidade() != 0 ? $estoque->getQuantidade() : "" ?>">                 
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label-custom" for="PRODUTO_PRECO">Preço <span class="required">*</span></label>
                                <input name="PRODUTO_PRECO" maxlength="6" required type="text" class="form-control inputNumber" placeholder="Digite..." value="<?php echo $produto->getPreco() != 0 ? $produto->getPreco() : "" ?>">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label-custom" for="PRODUTO_DESCONTO">Desconto<span></span></label>
                                <input name="PRODUTO_DESCONTO" maxlength="6" type="text" class="form-control inputNumber" placeholder="Digite..." value="<?php echo $produto->getDesconto() != 0 ? $produto->getDesconto() : "" ?>" >
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom" for="PRODUTO_DESC">Descrição<span></span></label>
                                <textarea name="PRODUTO_DESC" maxlength="1000" rows="7" type="text" class="form-control" placeholder="Digite..." value="" ><?php echo $produto->getDesc() ?></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-success mx-1" id="btnOk"><?php echo $acao == "C" ? "Cadastrar" : "Alterar" ?></button>
                                <a href="../produtoConsultar.php" class="btn btn-light mx-1">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <?php
        include_once("footerContent.html");
    ?>
</body>
<?php
    include_once("footer.html");
?>
</html>