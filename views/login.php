<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../res/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../res/css/index.css">
</head>
<body>
    <header>

    </header>
    <main>
        <div class="d-flex justify-content-center align-items-center">
            <div class="card mt-5" style="width: 24rem;">
                <div class="card-body">
                    <h3 class="card-title">Faça seu login</h5>
                    <form action="../login.php" method="post">
                        <div class="mb-1 mt-4">
                          <label for="usuario_email" class="form-label">E-mail</label>
                          <input type="email" class="form-control" name="ADM_EMAIL" id="ADM_EMAIL">
                        </div>
                        <div class="mb-5">
                          <label for="usuario_senha" class="form-label">Senha</label>
                          <input type="password" class="form-control" name="ADM_SENHA" id="ADM_SENHA">
                        </div>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <footer>

    </footer>
</body>
<script src="../res/bootstrap/js/bootstrap.min.js"></script>
</html>