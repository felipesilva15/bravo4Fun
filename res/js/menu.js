const btnMobile = document.getElementById('btn-mobile');

function toggleMenu(event) {
  if (event.type === 'touchstart') event.preventDefault();
  const nav = document.getElementById('nav');
  nav.classList.toggle('active');
  const active = nav.classList.contains('active');
  event.currentTarget.setAttribute('aria-expanded', active);
  if (active) {
    event.currentTarget.setAttribute('aria-label', 'Fechar Menu');
  } else {
    event.currentTarget.setAttribute('aria-label', 'Abrir Menu');
  }
}

btnMobile.addEventListener('click', toggleMenu);
btnMobile.addEventListener('touchstart', toggleMenu);

function montarMenu(idItem) {
  let itemProduto = document.getElementById('subItemProduto');

  if(itemProduto === null) {
    let lista = document.createElement('ul');

    let itemLista = document.createElement('li');
    itemLista.id = 'subItemProduto';
    
    let linkProduto = document.createElement('a');
    let linkCategoria = document.createElement('a');

    linkProduto.appendChild(document.createTextNode('Produto'));
    linkCategoria.appendChild(document.createTextNode('Categoria'));

    if(idItem === 'produtomenu') {
      linkProduto.setAttribute('href','../produtoConsultar.php');
      linkCategoria.setAttribute('href','../categoriaConsultar.php');
    }
    else{
      linkProduto.setAttribute('href','produtoConsultar.php');
      linkCategoria.setAttribute('href','categoriaConsultar.php');
    };

    itemLista.appendChild(linkProduto);
    itemLista.appendChild(linkCategoria);
    lista.id = 'listamenu';
    lista.appendChild(itemLista);

    let menu = document.getElementById('produtomenu');
    menu.appendChild(lista);
  } 
  else{
    let delMenu = document.getElementById('listamenu');
    delMenu.remove();

  };

  
}