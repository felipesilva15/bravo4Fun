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
</head>
<body class="default-height-body">
    <header>

    </header>
    <main class="full-height">
        <div class="m-3">
            <div class="box box-read p-2 margin-0">
                <div class="my-3">
                    <h3>Administrador - Consultar</h3>
                </div>
                <div class="m-2 mt-5 pb-1">
                    <form action="adminConsultar.php" method="get">
                        <div class="row g-3">
                            <div class="row col-auto me-auto col-md-9">
                                <div class="col-md-2">
                                    <label class="form-label-custom" for="id">ID</label>
                                    <input name="id" maxlength="500" type="number" class="form-control" placeholder="Digite..." value="<?php echo isset($_GET["id"]) ? $_GET["id"] : "" ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom" for="nome">Nome</label>
                                    <input name="nome" maxlength="500" type="text" class="form-control" placeholder="Digite..." autocomplete="off" value="<?php echo isset($_GET["nome"]) ? $_GET["nome"] : "" ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-custom" for="email">E-mail</label>
                                    <input name="email" maxlength="500" type="text" class="form-control" placeholder="Digite..." autocomplete="off" value="<?php echo isset($_GET["email"]) ? $_GET["email"] : "" ?>">
                                </div>
                            </div>
                             <div class="col-auto align-self-end">
                                    <button type="submit" class="btn btn-primary mx-1">Consultar</button>
                             </div>
                        </div>
                    </form>
                    <div class="mt-4 table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>
                                        <a href="views/adminDigitar.php" class="btn btn-success fw-bold btn-sm-custom">+ Incluir</a>
                                    </th>           
                                </tr>    
                            </thead>
                            <tbody class="table-group-divider">
                                <?php
                                    require_once("config.php");

                                    $admin = new Usuario();

                                    $admin->setId(isset($_GET["id"]) && $_GET["id"] !== "" ? $_GET["id"] : 0);
                                    $admin->setNome(isset($_GET["nome"]) ? $_GET["nome"] : "");
                                    $admin->setEmail(isset($_GET["email"]) ? $_GET["email"] : "");

                                    $data = $admin->getUsuarios();

                                    foreach ($data as $row) {
                                        $row["ADM_ATIVO"] = $row["ADM_ATIVO"] ?? 1;
                                        $styleInativo = $row["ADM_ATIVO"] == 0 ? 'style="text-decoration: line-through;"' : "";

                                        echo "
                                        <tr {$styleInativo}>
                                            <td>{$row["ADM_ID"]}</td>
                                            <td>{$row["ADM_NOME"]}</td>
                                            <td>{$row["ADM_EMAIL"]}</td>
                                            <td>
                                                <div class=\"d-flex flex-row\">
                                                    <div>
                                                        <a href=\"views/adminDigitar.php?id={$row["ADM_ID"]}\" class=\"btn  btn-sm-custom p-0\">
                                                            <img src=\"res/images/edit.png\" width=\"17px\" height=\"17px\">
                                                        </a>
                                                    </div>
                                                    <div class=\"ps-1\">
                                                        <a class=\"btn btn-sm-custom p-0\" onclick=\"adminExcluir({$row["ADM_ID"]})\">
                                                            <img src=\"res/images/delete.png\" width=\"18px\" height=\"18px\">
                                                        </a>
                                                    </div>
                                                    <div class=\"dropdown\">
                                                        <button class=\"btn btn-sm-custom dropdown-toggle\" type=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                                            <img src=\"res/images/more.png\" width=\"16px\" height=\"16px\">
                                                        </button>
                                                        <ul class=\"dropdown-menu\">
                                                            <li><a class=\"dropdown-item\" onclick=\"adminDesativar({$row["ADM_ID"]})\">Ativar / Detativar</a></li>
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
    <footer>
        
    </footer>
</body>
<script src="res/bootstrap/js/bootstrap.min.js"></script>
<script src="res/plugins/jQuery/jquery-3.6.1.min.js"></script>
<script src="res/plugins/input/jquery.maskMoney.js"></script>
<script src="res/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="res/bootstrap/js/bootstrap.esm.min.js"></script>
<script src="res/js/utils.js"></script>
<script src="res/js/mask.js"></script>
<script src="res/js/modal.js"></script>
<script src="res/js/api.js"></script>
<script>
    function adminExcluir(id){
        cfgModal = modal.config();

        cfgModal.type = "CONFIRM";
        cfgModal.title = "Atenção";
        cfgModal.extra1 = id;
        cfgModal.extra2 = "EXCLUIR";
        cfgModal.callback = () => {
            window.location.href = `adminExcluir.php?id=${id}`
        }

        modal.show(cfgModal);
    }

    function adminDesativar(id){
        cfgModal = modal.config();

        cfgModal.type = "CONFIRM";
        cfgModal.title = "Atenção";
        cfgModal.extra1 = id;
        cfgModal.extra2 = "DESATIVAR";
        cfgModal.callback = () => {
            window.location.href = `adminDesativar.php?id=${id}`
        };

        modal.show(cfgModal);
    }
</script>
</html>