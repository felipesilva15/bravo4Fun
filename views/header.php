<?php
    error_reporting(E_ERROR | E_PARSE);

    header("Cache-control: no-cache, no-store, must-revalidate");
?>

<header id="header">
    <nav id="nav">
    <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-expanded="false">
    <span id="span"></span>
     </button>
    <ul id="menu">
        <li><a  href="/produtoConsultar.php">Produto</a></li>
        <li><a  href="/categoriaConsultar.php">Categoria</a></li>
        <li><a  href="/adminConsultar.php">Administrador</a></li>
     </ul>
     </nav>
     <a id="logo" href="/views/menu.php">Bravo 4 Fun</a>
     <div class="dropdown">
        <a id="btndrop btndrop-secondary dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <button aria-label="Abrir Menu" id="btn-mobile" aria-haspopup="true" aria-expanded="false">    
                <img id="semfoto" src="/res/images/semfoto.png" width="50">
            </button>
        </a>
        <ul id="dropdown-menu" class="dropdown-menu pb-3 pt-3">
            <li><a href="#" onclick="logout()">Logout</a></li>
        </ul>
    </div>
</header>