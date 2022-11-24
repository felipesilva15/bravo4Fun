<?php
    require_once("../config.php");
    require_once("../class/ProdutoImagem.php");
    require_once("../class/Sql.php");
    
    $produtoImagem = new ProdutoImagem();
    
    $produtoImagem->setProduto(isset($_GET["id"]) ? $_GET["id"] : 0);
    $data = $produtoImagem->getProdutoImagens();
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
    <?php
        include_once("header.php");
    ?>
    <main class="full-height">
        <div class="m-3">
            <div class="box box-dig p-2 margin-0">
                <div class="my-3">
                    <h3>Produto - Imagens e ordens</h3>
                </div>
                <div class="m-2 mt-4">
                    <form id="form-js" action="produtoOrdemImagem.php" method="post">
                        <div class="row g-3">
                            <input name="PRODUTO_ID" id="PRODUTO_ID" required type="hidden" class="form-control" placeholder="" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : 0?>">
                            <div class="p-3 margin-0">
                                <div class="mb-3">
                                    <h4>Imagens descartadas</h4>
                                </div>
                                <div class="row g-3 column" id="produtosDescartados">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2" draggable="true">
                                        <form action="" method="" id="formItemAdd"></form>
                                        <form action="" method="" id="formItemAdd">
                                            <label class="form-label-custom" for="inputFileUpload">
                                                <div class="box box-none-border margin-0 item-add">
                                                    <img draggable="false" src="/bravo4Fun/res/images/plus-symbol-button.png" alt="" height="auto" class="plus-button-icon">
                                                </div>
                                            </label>
                                            <input name="inputFileUpload" id="inputFileUpload" type="file" accept="image/*" class="form-control" placeholder="Digite...">
                                        </form>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 margin-0">
                                <div class="mb-3">
                                    <h4>Imagens selecionadas</h4>
                                </div>
                                <div class="row g-3 column" id="produtosSelecionados">
                                    <?php
                                        foreach ($data as $row) {
                                            echo "
                                                <div class=\"col-12 col-sm-6 col-md-4 col-lg-2 item\" draggable=\"true\">
                                                    <div class=\"box box-none-border margin-0 item-card\" imageId=\"{$row["IMAGEM_ID"]}\" imageUrl=\"{$row["IMAGEM_URL"]}\">
                                                        <img draggable=\"false\" class=\"p-1 item-img\" src=\"{$row["IMAGEM_URL"]}\">
                                                    </div>
                                                </div>
                                            ";
                                        }
                                    ?>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-2" id="designBox">
                                        <div style="aspect-ratio: 9/9;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-success mx-1" id="btnOk">Alterar</button>
                                <a href="../produtoConsultar.php" class="btn btn-light mx-1">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
    <?php
        include_once("footer.html");
    ?>
<script src="/bravo4Fun/res/js/produtoOrdemImagem.js"></script>
</html>