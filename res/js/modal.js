const modal = {};
let modalToDisplay = null

// Retorna um objeto com as propriedades do modal 
modal.config = () => {
    return {
        type: "", // INFO, CONFIRM, CUSTOM, ERROR, IMAGEZOOM
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

    modalToDisplay = document.createElement("div");
    let url = ""

    if(cfgModal.type.toUpperCase() !== "CUSTOM"){
        url = `res/modals/${cfgModal.type}.html`;
    } else{
        url = `res/modals/${cfgModal.body}.html`
    }
    
    let request = api.requestArchive(url, "GET");

    request
        .then((res) => {
            modalToDisplay.innerHTML = res;

            $("body").append(modalToDisplay);

            switch (cfgModal.type.toUpperCase()) {
                case "INFO":
                    $(".modal-body").last().append(cfgModal.body);

                    break;
                
                case "CONFIRM": 
                    let text = $("#modal-confirm-text").text().replace("[ACAO]", cfgModal.extra2).replace("[ID]", cfgModal.extra1);
                    $("#modal-confirm-text").text(text);

                    break;

                case "CUSTOM":
                    // Carregar arquivos da pasta de modals  
                    
                    break;

                case "ERROR":
                    $("#error-title").append(cfgModal.body.title);  
                    $("#error-message").append(cfgModal.body.message);  

                    break;
                
                case "IMAGEZOOM":
                    $("#imgZoom").attr("src", cfgModal.extra1);

                    break;

                case "CONFIRMCUSTOM":
                    $("#msgModal").text(cfgModal.extra1);

                    break;
            }

        
            if($("#modal-title").text() == ""){
                $("#modal-title").append(document.createTextNode(cfgModal.title));
            }

            if($("#modal-btnOk")){
                $("#modal-btnOk").on("click", cfgModal.callback);
            }

            let modalBootstrap = new bootstrap.Modal(document.getElementById("modal-js"));

            modalBootstrap.show();
        })
        .catch((err) => {
            modalToDisplay.innerHTML = "";
        });
}

// Fecha o modal
modal.close = () => {
    if (modalToDisplay !== null){
        modalToDisplay.remove();
    }
}