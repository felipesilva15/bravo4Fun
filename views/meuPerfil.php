<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil</title>
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
            <li><a  href="/bravo4Fun/categoriaConsultar.php">Categoria</a></li>
            <li><a  href="/bravo4Fun/adminConsultar.php">Administrador</a></li>
         </ul>
         </nav>
         <a id="logo" href="/bravo4Fun/views/menu.php">Bravo4 Fun</a>
        <img id="semfoto" src="../res/images/semfoto.png" width="50">
     </header>
    <main class="full-height">
        <div class="mt-5 full-height d-flex justify-content-center align-items-center">
            <div class="box box-read p-5 margin-0" style="max-width: 400px">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <h3 class="mb-3 card-title">Meu Perfil</h5>
                    </div>
                    <div style='text-align:center'>
                        <img src="../res/images/semfoto.png" id="semfoto" class="usuario" width="130" height="130" alt="Foto do Perfil">
                    </div>
                    <form id="form-js" action="login.php" method="post" redirect="views\menu.php">
                        <div class="mb-1 mt-4 div-inline-input">
                            <input type="email" class="inline-input" name="ADM_ID" id="ADM_ID" required>
                            <label for="usuario_id" class="form-label">ID</label>
                        </div>
                        <div class="mb-1 mt-4 div-inline-input">
                            <input type="email" class="inline-input" name="ADM_NOME" id="ADM_NOME" required>
                            <label for="usuario_nome" class="form-label">Nome*</label>
                        </div>
                        <div class="mb-1 mt-4 div-inline-input">
                            <input type="email" class="inline-input" name="ADM_EMAIL" id="ADM_EMAIL" required>
                            <label for="usuario_email" class="form-label">E-mail*</label>
                        </div>
                        <div class="mb-1 mt-4 div-inline-input">
                            <input type="password" class="inline-input" name="ADM_SENHA" id="ADM_SENHA" required>
                            <label for="usuario_senha" class="form-label">Senha*</label>
                        </div>
                        <div class="mb-5 div-inline-input">
                            <input type="password" class="inline-input" name="ADM_SENHA" id="ADM_SENHA" required>
                            <label for="usuario_senha" class="form-label">Confirme sua senha*</label>
                        </div>
                        <div class="mb-5 col-auto align-self-start">
                            <div class="d-flex column align-itens-start">
                                <button type="submit" class="btn btn-white" style="width: 40%;" type="button" id="btnOk">Cancelar</button>
                                <button type="submit" class="btn btn-dark" style="width: 40%;" type="button" id="btnOk">Alterar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer class="login-footer">
        <div class="full-height d-flex justify-content-center align-items-center">
            <span>Copyright © 2022 All Rights Reserved</span>
        </div>
    </footer>
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