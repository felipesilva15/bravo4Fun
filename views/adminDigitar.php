<?php
    require_once("../config.php");
    require_once("../class/Usuario.php");
    require_once("../class/Sql.php");
    
    $admin = new Usuario();
    
    $admin->setId(isset($_GET["id"]) ? $_GET["id"] : 0);
    $admin->loadById();
    
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
</head>
<body class="default-height-body">
    <main class="full-height">
        <div class="m-3">
            <div class="box box-dig p-2 margin-0">
                <div class="my-3">
                    <h3>Administrador - <?php echo $acao == "C" ? "Incluir" : "Alterar" ?></h3>
                </div>
                <div class="m-2 mt-4">
                    <form action="<?php echo $acao == "C" ? "../adminIncluir.php" : "../adminAlterar.php" ?>" method="post">
                        <div class="row g-3">
                            <input name="ADM_ID" required type="hidden" class="form-control" placeholder="" value="<?php echo isset($_GET["id"]) ? $_GET["id"] : 0 ?>">
                            <div class="col-md-6">
                                <label class="form-label-custom" for="ADM_NOME">Nome<span class="required">*</span></label>
                                <input name="ADM_NOME" maxlength="500" required type="text" class="form-control" placeholder="Digite..." value="<?php echo $admin->getNome() ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-custom" for="ADM_EMAIL">E-mail<span class="required">*</span></label>
                                <input name="ADM_EMAIL" maxlength="500" required type="text" class="form-control" placeholder="Digite..." value="<?php echo $admin->getEmail() ?>">
                            </div>
                            <div class="col-12">
                                <label class="form-label-custom" for="ADM_SENHA">Senha<span class="required">*</span></label>
                                <input name="ADM_SENHA" maxlength="500" type="password" class="form-control" placeholder="Digite...">
                            </div>
                            <div class="col-12 mt-5">
                                <button type="submit" class="btn btn-success mx-1"><?php echo $acao == "C" ? "Cadastrar" : "Alterar" ?></button>
                                <a href="../adminConsultar.php" class="btn btn-light mx-1">Cancelar</a>
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
<script src="../res/bootstrap/js/bootstrap.esm.min.js"></script>
<script src="../res/js/utils.js"></script>
<script src="../res/js/mask.js"></script>
<script src="../res/js/modal.js"></script>
<script src="../res/js/api.js"></script>
</html>