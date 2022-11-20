<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bravo 4 Fun</title>
    <link rel="shortcut icon" href="res/images/logo.ico">
    <link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="res/css/global.css">
    <link rel="stylesheet" href="res/css/menu.css">
    <link rel="stylesheet" href="/bravo4Fun/node_modules/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="/bravo4Fun/res/css/fixSelect2Theme.css">
    <link rel="stylesheet" href="/bravo4Fun/res/css/inputImagePreview.css">
</head>
<body class="default-height-body">
    <?php
        include_once("views/header.html");
    ?>
    <main class="full-height">
        <div class="m-3">
            <div class="box box-read p-2 margin-0">
                <div class="my-3">
                    <h3>Produto - Consultar</h3>
                </div>
                <div class="m-2 mt-5 pb-1">
                    <form action="produtoConsultar.php" method="get">
                        <div class="row g-3">
                            <div class="row col-auto me-auto col-md-9">
                                <div class="col-12 col-md-2">
                                    <label class="form-label-custom" for="id">ID</label>
                                    <input name="id" min="0" type="number" class="form-control" placeholder="Digite..." value="<?php echo isset($_GET["id"]) ? $_GET["id"] : "" ?>">
                                </div>   
                                <div class="col-12 col-md-4">
                                    <label class="form-label-custom" for="nome">Nome</label>
                                    <input name="nome" maxlength="100" type="text" class="form-control" placeholder="Digite..." autocomplete="off" value="<?php echo isset($_GET["nome"]) ? $_GET["nome"] : "" ?>">
                                </div>
                                <div class="col-12 col-md-5">
                                    <label class="form-label-custom" for="categoria">Categoria</label>
                                    <select class="form-select select2AutoConfig" select2Config="CATEGORIA" select2ValueToSelect="<?php echo isset($_GET["categoria"]) ? $_GET["categoria"] : "" ?>" placeholder="Selecione" name="categoria">
                                        <option value="0">Selecione...</option>
                                    </select>
                                </div>                                                                                                                                                                                             
                            </div>
                            <div class="col-auto align-self-end">
                                <div class="d-flex column align-itens-end">
                                    <div class="form-check m-1 me-4">
                                        <input class="form-check-input" type="checkbox" name="inativo" value="1" id="inativo" <?php echo isset($_GET["inativo"]) && $_GET["inativo"] == 1 ? "checked" : "" ?>>
                                        <label class="form-check-label" for="inativo">Exibir inativos</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary mx-1">Consultar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="mt-4 table-responsive">
                        <table class="table table-striped table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Categoria</th>
                                    <th>Preço</th>
                                    <th>Desconto</th>
                                    <th>Qtd. em estoque</th>
                                    <th>Imagem Principal</th>
                                    <th>
                                        <a href="views\produtoDigitar.php" class="btn btn-success fw-bold btn-sm-custom">+ Incluir</a>
                                    </th>           
                                </tr>    
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                    require_once("config.php");

                                    $produto = new Produto();

                                    $produto->setId(isset($_GET["id"]) && $_GET["id"] !== "" ? $_GET["id"] : 0);
                                    $produto->setNome(isset($_GET["nome"]) ? $_GET["nome"] : "");   
                                    $produto->setCategoria(isset($_GET["categoria"]) && $_GET["categoria"] != "" ? $_GET["categoria"] : 0);   
                                    $exibirInativo = isset($_GET["inativo"]) ? $_GET["inativo"] : 0;                                                                 

                                    $data = $produto->getProdutos($exibirInativo);                

                                    foreach ($data as $row) {
                                        $row["PRODUTO_ATIVO"] = $row["PRODUTO_ATIVO"] ?? 1;
                                        $styleInativo = $row["PRODUTO_ATIVO"] == 0 ? 'style="text-decoration: line-through;"' : "";
                                        $acaoAtivo = $row["PRODUTO_ATIVO"] ?? 1 == 1 ? "DESATIVAR" : "ATIVAR";
                                        $produto = substr($row["PRODUTO_NOME"], 0, 20);
                                        $desc = substr($row["PRODUTO_DESC"], 0, 50);
                                        echo "
                                        <tr {$styleInativo}>
                                            <td>{$row["PRODUTO_ID"]}</td>  
                                            <td>{$produto}</td>                                       
                                            <td>{$desc}</td>  
                                            <td>{$row["CATEGORIA_NOME"]}</td>
                                            <td class=\"textNumber textMoneySymbol\">{$row["PRODUTO_PRECO"]}</td>
                                            <td class=\"textNumber textMoneySymbol\">{$row["PRODUTO_DESCONTO"]}</td>
                                            <td class=\"textNumber\" decimalPlaces=\"0\">{$row["PRODUTO_QTD"]}</td>
                                            <td>
                                            <div class=\"btn  btn-sm-custom p-0\" id=\"btnZoomImage\">
                                                <a onclick=\"produtoZoomImagem('{$row["IMAGEM_URL"]}')\">Clique para ver</a>
                                                <img src=\"res/images/imagem.png\" class=\"iconsImagePreview\">
                                            </button>
                                            </div>
                                            </td>
                                            <td>
                                                <div class=\"d-flex flex-row\">
                                                    <div>
                                                        <a href=\"views/produtoDigitar.php?id={$row["PRODUTO_ID"]}\" class=\"btn  btn-sm-custom p-0\">
                                                        </a>
                                                    </div>
                                                    <div class=\"dropdown\">
                                                        <button class=\"btn btn-sm-custom dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                                            <img src=\"res/images/more.png\" width=\"16px\" height=\"16px\">
                                                        </button>
                                                        <ul class=\"dropdown-menu\">
                                                            <li><a class=\"dropdown-item\" onclick=\"produtoDesativar({$row["PRODUTO_ID"]}, '{$acaoAtivo}')\">Ativar / Desativar</a></li>
                                                            <li><a class=\"dropdown-item\" href=\"views/produtoOrdemImagem.php?id={$row["PRODUTO_ID"]}\">Todas as imagens</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
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
    </main>
</body>
    <?php
        include_once("views/footer.html");
    ?>
<script>
    function produtoDesativar(id, acao){
        cfgModal = modal.config();

        cfgModal.type = "CONFIRM";
        cfgModal.title = "Atenção";
        cfgModal.extra1 = id;
        cfgModal.extra2 = acao;
        cfgModal.callback = () => {
            let request = api.request(`produtoDesativar.php?id=${id}`, "GET");
        
            request
                .then((res) => {
                    window.location.reload()
                })
                .catch((err) => {
                    modal.close()

                    cfgModalError = modal.config();

                    cfgModalError.type = "ERROR";
                    cfgModalError.title = "Erro ao processar a solicitação";
                    cfgModalError.body = err;

                    modal.show(cfgModalError);
                });
        };

        modal.show(cfgModal);
    }

    function produtoZoomImagem(urlImage){
        if(urlImage == ""){
            urlImage = "/bravo4Fun/res/images/produto-sem-foto.jpg"
        }

        cfgModal = modal.config();

        cfgModal.type = "IMAGEZOOM";
        cfgModal.extra1 = urlImage;

        modal.show(cfgModal);
    }
</script>
</html>