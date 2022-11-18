const columns = document.querySelectorAll(".column");
const formItemAdd = document.querySelector("#formItemAdd");
const inputItemAdd = document.querySelector("#inputFileUpload");
const btnOk = document.querySelector("#btnOk");
const produtoId = parseInt(document.querySelector("#PRODUTO_ID").value);
const designBox = document.querySelector("#designBox");

document.addEventListener("dragstart", (e) => {
    e.target.classList.add("dragging");
});

document.addEventListener("dragend", (e) => {
    e.target.classList.remove("dragging");
});

inputItemAdd.addEventListener("change", (e) => {
    if (!inputItemAdd.files[0]){
        return;
    }

    let data = new FormData(formItemAdd);
    
    let request = api.request("upload.php", "POST", data);

    request
        .then((res) => {
            createItem(res.items.filePath);
        })
        .catch((err) => {
            cfgModalError = modal.config();

            cfgModalError.type = "ERROR";
            cfgModalError.title = "Atenção";
            cfgModalError.body = err;

            modal.show(cfgModalError);
        });
});

columns.forEach((item) => {
    item.addEventListener("dragover", (e) => {
        const dragging = document.querySelector(".dragging");
        const applyAfter = getNewPosition(item, e.clientX, e.clientY);

        if (applyAfter) {
            applyAfter.insertAdjacentElement("afterend", dragging);
        } else {
            item.prepend(dragging);
        }

        checkDesignBox()
    });
});

function getNewPosition(column, posX, posY) {
    const cards = column.querySelectorAll(".item:not(.dragging)");
    let result;

    cards.forEach((refer_card) => {
        const box = refer_card.getBoundingClientRect();
        const boxCenterX = box.x + box.width / 2;

        if (posX >= boxCenterX && posY >= box.y && posY <= box.y + box.height){
            result = refer_card;
        }
    });

    return result;
}

function createItem(imageUrl){
    $("#produtosDescartados").prepend(`<div class="col-12 col-sm-6 col-md-4 col-lg-2 item" draggable="true">
        <div class="box box-none-border margin-0 item-card" imageId="0" imageUrl="${imageUrl}">
            <img draggable="false" class="p-1 item-img" src="${imageUrl}" alt="">
        </div>
    </div>`)
}

btnOk.addEventListener("click", (e) => {
    e.preventDefault();

    let data = prepareDataToSave();
    let request = api.request("produtoOrdemImagem.php", "POST", data);

    request
        .then((res) => {
            window.location.href = "/bravo4Fun/produtoConsultar.php";
        })
        .catch((err) => {
            cfgModalError = modal.config();

            cfgModalError.type = "ERROR";
            cfgModalError.title = "Atenção";
            cfgModalError.body = err;

            modal.show(cfgModalError);
        });
})

function prepareDataToSave(){
    let produtosDescartados = document.querySelectorAll("#produtosDescartados .item-card");
    let produtosSelecionados = document.querySelectorAll("#produtosSelecionados .item-card");

    let imagens = [];

    produtosSelecionados.forEach((element, index) => {
        imagens.push({
            IMAGEM_ID: parseInt(element.getAttribute("imageid")),
            IMAGEM_URL: element.getAttribute("imageurl"),
            IMAGEM_ORDEM: index
        })
    });

    produtosDescartados.forEach((element, index) => {
        // Adiciona apenas as imagens descartadas que já foram salvas no BD
        if(element.getAttribute("imageid") && element.getAttribute("imageid") != 0){
            imagens.push({
                IMAGEM_ID: parseInt(element.getAttribute("imageid")),
                IMAGEM_URL: element.getAttribute("imageurl"),
                IMAGEM_ORDEM: -1
            });
        }
    });

    let data = new FormData();

    data.append("PRODUTO_ID", produtoId);

    for (var i = 0, valuePair; valuePair = imagens[i]; i++){
        for (var j in valuePair){
            data.append(`IMAGENS[${i}][${j}]`, valuePair[j]);
        }
    }
    
    return(data);
}

function checkDesignBox(){
    let produtosSelecionados = document.querySelectorAll("#produtosSelecionados .item-card");

    if(produtosSelecionados && produtosSelecionados.length > 0){
        designBox.style.display = "none";
    } else{
        designBox.style.display = "block";
    }
}

checkDesignBox();