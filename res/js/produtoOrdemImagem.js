const columns = document.querySelectorAll(".column");
const formItemAdd = document.querySelector("#formItemAdd");
const inputItemAdd = document.querySelector("#inputFileUpload");

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
            console.log(res);
            createItem(res.items.filePath);
        })
        .catch((err) => {
            console.log(err);

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
        const applyAfter = getNewPosition(item, e.clientX);

        if (applyAfter) {
            applyAfter.insertAdjacentElement("afterend", dragging);
        } else {
            item.prepend(dragging);
        }
    });
});

function getNewPosition(column, posX) {
    const cards = column.querySelectorAll(".item:not(.dragging)");
    let result;

    for (let refer_card of cards) {
        const box = refer_card.getBoundingClientRect();
        const boxCenterX = box.x + box.width / 2;

        if (posX >= boxCenterX){
            result = refer_card
        };
    }

    return result;
}

function createItem(imageUrl){
    $("#produtosDescartados").prepend(`<div class="col-12 col-sm-6 col-md-4 col-lg-2 item" draggable="true">
        <div class="box box-none-border margin-0 item-card" imageId="0" imageUrl="${imageUrl}">
            <img draggable="false" class="p-1 item-img" src="${imageUrl}" alt="">
        </div>
    </div>`)
}