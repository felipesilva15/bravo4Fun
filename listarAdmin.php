<html>
    <head>
        <title>Listar os Administradores</title>
    </head>
    <body>
        <h1>Listar os Administradores</h1>
        <br>
        <table border="1">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Atualizacao</th>
                <th>Exclusao</th>            
            </tr>
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
        </table>
        <br>
        <a href="../index.html">Voltar para o Indice</a>    
    </body>
</html>