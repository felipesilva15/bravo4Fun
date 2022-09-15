const modal = {};

// Retorna um objeto com as propriedades do modal 
modal.config = () => {
    return {
        type: "", // INFO, CONFIRM, CUSTOM
        title: "",
        body: "",
        callback: () => {}
    };
}

// Exibe o modal com base nas propriedades definidas para o mesmo
modal.show = (cfgModal) => {

}

// Fecha o modal
modal.close = (cfgModal) => {

}