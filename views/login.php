<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="../res/images/logo.ico">
    <link rel="stylesheet" href="../res/bootstrap/css/bootstrap.min.css">
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
                        <h3 class="mb-3 card-title">Faça login</h5>
                    </div>
                    <form action="../login.php" method="post">
                        <div class="mb-1 mt-4 div-inline-input">
                          <input type="email" class="inline-input" name="ADM_EMAIL" id="ADM_EMAIL"  required>
                          <label for="usuario_email" class="form-label">E-mail</label>
                        </div>
                        <div class="mb-5 div-inline-input">
                          <input type="password" class="inline-input" name="ADM_SENHA" id="ADM_SENHA" required>
                          <label for="usuario_senha" class="form-label">Senha</label>
                        </div>
                        <div class="mb-5 d-grid gap-2">
                            <button type="submit" class="btn btn-dark" style="width: 100%;" type="button">Entrar</button>
                        </div>
                        <div class="mt-5">
                            <span>Não possui um cadastro? <a href="novoLogin.php">Crie agora</a></span>
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