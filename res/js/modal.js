const modal = {};
let modalToDisplay = null

// Retorna um objeto com as propriedades do modal 
modal.config = () => {
    return {
        type: "", // INFO, CONFIRM, CUSTOM, ERROR
        title: "",
        body: "",
        extra1: "", 
        extra2: "", // EXCLUIR, DESATIVAR
        callback: () => {}
    };
}

// Exibe o modal com base nas propriedades definidas para o mesmo
modal.show = (cfgModal) => {
    if (modalToDisplay !== null){
        modalToDisplay.remove();
    }

    modalToDisplay = document.createElement('div');

    modalToDisplay.innerHTML = `
    <div id="modal-js" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${cfgModal.title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    `;

    switch (cfgModal.type) {
        case "INFO":
            modalToDisplay.querySelector('.modal-body').innerHTML = cfgModal.body;
            modalToDisplay.querySelector('.modal-footer').innerHTML = `<button type="button" class="btn btn-light" data-bs-dismiss="modal" id="modal-btn-ok">Ok</button>`;

            document.body.append(modalToDisplay);
            modalToDisplay.querySelector('#modal-btn-ok').onclick = cfgModal.callback;
            
            break;
        
        case "CONFIRM": 
            modalToDisplay.querySelector('.modal-body').innerHTML = `<p>Deseja mesmo ${cfgModal.extra2} o registro de ID ${cfgModal.extra1}?</p>`;
            modalToDisplay.querySelector('.modal-footer').innerHTML = `
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Não</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="modal-btn-yes">Sim</button>`;

            document.body.append(modalToDisplay);
            modalToDisplay.querySelector('#modal-btn-yes').onclick = cfgModal.callback;

            break;

        case "CUSTOM":
            // Carregar arquivos da pasta de modals  
            
            break;

        case "ERROR":
            modalToDisplay.querySelector('.modal-body').innerHTML = cfgModal.body;    
            modalToDisplay.querySelector('.modal-footer').innerHTML = `<button type="button" class="btn btn-light" data-bs-dismiss="modal" id="modal-btn-ok">Ok</button>`;

            document.body.append(modalToDisplay);
            modalToDisplay.querySelector('#modal-btn-ok').onclick = cfgModal.callback;

            break;
    }

    let modalBootstrap = new bootstrap.Modal(modalToDisplay.querySelector('#modal-js'));

    modalBootstrap.show();
}

// Fecha o modal
modal.close = () => {
    if (modalToDisplay !== null){
        modalToDisplay.remove();
    }
}