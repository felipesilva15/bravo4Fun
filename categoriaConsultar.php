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
</head>
<body class="default-height-body">
    <?php
        include_once("views/header.php");
    ?>
    <main class="full-height mb-5">
        <div class="m-3 pb-5">
            <div class="box box-read p-2 margin-0">
                <div class="my-3">
                    <h3>Categoria - Consultar</h3>
                </div>
                <div class="m-2 mt-5 pb-1">
                    <form action="categoriaConsultar.php" method="get">
                        <div class="row g-3">
                            <div class="row col-auto me-auto col-md-9">
                                <div class="col-md-2">
                                    <label class="form-label-custom" for="id">ID</label>
                                    <input name="id" maxlength="500" type="number" class="form-control" placeholder="Digite..." value="<?php echo isset($_GET["id"]) ? $_GET["id"] : "" ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom" for="nome">Categoria</label>
                                    <input name="nome" maxlength="500" type="text" class="form-control" placeholder="Digite..." autocomplete="off" value="<?php echo isset($_GET["nome"]) ? $_GET["nome"] : "" ?>">
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
                    </form>
                    <div class="mt-4 table-responsive">
                        <table class="table table-striped table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>
                                        <a href="views/categoriaDigitar.php" class="btn btn-success fw-bold btn-sm-custom">+ Incluir</a>
                                    </th>           
                                </tr>    
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                    require_once("config.php");

                                    $categoria = new Categoria();

                                    $categoria->setId(isset($_GET["id"]) && $_GET["id"] !== "" ? $_GET["id"] : 0);
                                    $categoria->setNome(isset($_GET["nome"]) ? $_GET["nome"] : "");
                                    $exibirInativo = isset($_GET["inativo"]) ? $_GET["inativo"] : 0;

                                    $data = $categoria->getCategorias($exibirInativo);

                                    foreach ($data as $row) {
                                        $row["CATEGORIA_ATIVO"] = $row["CATEGORIA_ATIVO"] ?? 1;
                                        $styleInativo = $row["CATEGORIA_ATIVO"] == 0 ? 'style="text-decoration: line-through;"' : "";
                                        $acaoAtivo = $row["CATEGORIA_ATIVO"] ?? 1 == 1 ? "DESATIVAR" : "ATIVAR";

                                        $desc = substr($row["CATEGORIA_DESC"], 0, 120);
                                        $desc .= (strlen($row["CATEGORIA_DESC"]) > 120) ? "..." : "";

                                        echo "
                                        <tr {$styleInativo}>
                                            <td>{$row["CATEGORIA_ID"]}</td>
                                            <td>{$row["CATEGORIA_NOME"]}</td>
                                            <td>{$desc}</td>
                                            <td>
                                                <div class=\"d-flex flex-row\">
                                                    <div>
                                                        <a href=\"views/categoriaDigitar.php?id={$row["CATEGORIA_ID"]}\" class=\"btn  btn-sm-custom p-0\">
                                                            <img src=\"res/images/edit.png\" width=\"17px\" height=\"17px\">
                                                        </a>
                                                    </div>
                                                    <div class=\"dropdown\">
                                                        <button class=\"btn btn-sm-custom dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                                            <img src=\"res/images/more.png\" width=\"16px\" height=\"16px\">
                                                        </button>
                                                        <ul class=\"dropdown-menu\">
                                                            <li><a class=\"dropdown-item\" onclick=\"categoriaDesativar({$row["CATEGORIA_ID"]}, '{$acaoAtivo}')\">Ativar / Desativar</a></li>
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
    <?php
        include_once("views/footerContent.html");
    ?>
</body>
    <?php
        include_once("views/footer.html");
    ?>
<script>
    function categoriaDesativar(id, acao){
        cfgModal = modal.config();

        cfgModal.type = "confirm";
        cfgModal.title = "Atenção";
        cfgModal.extra1 = id;
        cfgModal.extra2 = acao;
        cfgModal.callback = () => {
            let request = api.request(`categoriaDesativar.php?id=${id}`, "GET");
        
            request
                .then((res) => {
                    window.location.reload()
                })
                .catch((err) => {
                    modal.close()

                    cfgModalError = modal.config();

                    cfgModalError.type = "error";
                    cfgModalError.title = "Erro ao processar a solicitação";
                    cfgModalError.body = err;

                    modal.show(cfgModalError);
                });
        };

        modal.show(cfgModal);
    }
</script>
</html>