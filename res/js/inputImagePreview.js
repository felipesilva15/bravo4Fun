const inputFileImage = document.getElementById("inputFileImage");
const imagePreview = document.getElementById("imagePreview");
const btnDownloadImage = document.getElementById("btnDownloadImage");
const btnClearImage = document.getElementById("btnClearImage");
const btnZoomImage = document.getElementById("btnZoomImage"); 

inputFileImage.addEventListener("change", (e) => {
    changeImage();
})

btnClearImage.addEventListener("click", (e) => {
    e.preventDefault()

    clearImagePreview();
})

btnZoomImage.addEventListener("click", (e) => {
    e.preventDefault();

    zoomImage();
})

function changeImage() { 
    // Pega o arquivo selecionado
    let fileImage = inputFileImage.files[0];

    // Caso não seja selecionado um arquivo, limpa a imagem do elemento
    if (!fileImage){
        clearImagePreview();
        return;
    }

    readImage(fileImage);
}

function clearImagePreview() { 
    btnDownloadImage.removeAttribute("href")
    imagePreview.style.backgroundImage = "";
    imagePreview.style.display = "none";
}

function readImage(fileImage){
    // Cria o leitor de arquivos
    const reader = new FileReader();

    // Quando o arquivo for lido, atualiza o src da imagem
    reader.addEventListener("load", (e) => {
        imagePreview.style.backgroundImage = `url("${reader.result}")`;
        btnDownloadImage.setAttribute("href", reader.result)
        imagePreview.style.display = "block";
    })

    // Realiza a leitura da imagem
    reader.readAsDataURL(fileImage);
}

function zoomImage() { 
    let fileImage = btnDownloadImage.getAttribute("href");

    if(!fileImage){
        return;
    }

    cfgModal = modal.config();

    cfgModal.type = "imageZoom";
    cfgModal.extra1 = fileImage;

    modal.show(cfgModal);
}