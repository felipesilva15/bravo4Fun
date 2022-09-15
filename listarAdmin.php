<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listar </title>
        <link rel="shortcut icon" href="res/images/logo.ico">
        <link rel="stylesheet" href="res/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="res/css/global.css">
    </head>
    <body>
        <div class="mx-3 my-3">
            <h1 class="mb-5">Listar administradores</h1>
            <table class="mb-5 table table-striped table-hover table-responsive-sm">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Senha</th>
                        <th>Atualização</th>
                        <th>Exclusão</th>            
                    </tr>    
                </thead>
                <tbody>
                    <?php
                        require_once("config.php");

                        $usuario = new Usuario();

                        $usuarios = $usuario->getUsuarios();

                        foreach ($usuarios as $user) {
                            echo "<tr>";

                            echo "<td>{$user["ADM_ID"]}</td>";
                            echo "<td>{$user["ADM_NOME"]}</td>";
                            echo "<td>{$user["ADM_EMAIL"]}</td>";
                            echo "<td>{$user["ADM_SENHA"]}</td>";
                            echo '<td><a href="views\atualizarform.php?id='.$user["ADM_ID"].'">Atualizar</a></td>';
                            echo '<td><a href="excluirform.php?id='.$user["ADM_ID"].'">Excluir</a></td>';

                            echo "</tr>";
                        }
                    ?>    
                </tbody>   
            </table>
            <a href="views/login.html">Voltar para o login</a>
        </div>    
    </body>
</html>