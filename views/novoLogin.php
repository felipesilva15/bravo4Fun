<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua conta</title>
    <link rel="shortcut icon" href="../res/images/logo.ico">
    <link rel="stylesheet" href="../res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/index.css">
    <link rel="stylesheet" href="../res/css/global.css">
</head>
<body class="default-height-body">
    <header>

    </header>
    <main class="full-height">
        <div class="full-height d-flex justify-content-center align-items-center">
            <div class="card border-0 shadow p-3 mb-5 bg-body rounded" style="width: 24rem;">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center">
                        <h3 class="mb-3 card-title">Crie sua conta</h5>
                    </div>
                    <form action="../novoLogin.php" method="post">
                        <div class="mb-1 mt-4 div-inline-input">
                          <input type="text" class="inline-input" name="ADM_NOME" id="ADM_NOME" autocomplete="off" required>
                          <label for="ADM_NOME" class="form-label">Nome</label>
                        </div>
                        <div class="mb-1 div-inline-input">
                          <input type="email" class="inline-input" name="ADM_EMAIL" id="ADM_EMAIL" required>
                          <label for="ADM_EMAIL" class="form-label">E-mail</label>
                        </div>
                        <div class="mb-1 div-inline-input">
                          <input type="password" class="inline-input" name="ADM_SENHA" id="ADM_SENHA" required>
                          <label for="ADM_SENHA" class="form-label">Senha</label>
                        </div>
                        <div class="mb-5 div-inline-input">
                          <input type="password" class="inline-input" name="ADM_SENHACONF" id="ADM_SENHACONF" required>
                          <label for="ADM_SENHACONF" class="form-label">Confirme sua senha</label>
                        </div>
                        <div class="mb-5 d-grid gap-2">
                            <button type="submit" class="btn btn-dark" style="width: 100%;" type="button">Cadastrar</button>
                        </div>
                        <div class="mt-5">
                            <span>Já possui um cadastro? <a href="login.php">Faça login</a></span>
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
<script src="../res/bootstrap/js/bootstrap.min.js"></script>
</html>