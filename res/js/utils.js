// Pega uma data JS e a formata para uma string
function dateToString(date){

}

// Pega uma data em formato de string e a formata para uma data
function stringToDate(date){

}

// Recebe um valor e o formata com as casas decimais desejadas
function arredondar(value, decimalPlaces){
    
}

function validarCredenciais() {
    let request = api.request("validarCredenciais.php", "GET");

    request
        .then((res) => {
            console.log(res);
        })
        .catch((err) => {
            window.location.href = "/bravo4Fun/views/login.html";
        });
}