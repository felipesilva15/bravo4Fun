// Carrega as máscaras de todos os campos com base na classe deles
function loadMasks(){
    // Máscara de números para input
    $(".inputNumber").each((i, singleElement) => {
        maskElementNumber(singleElement);
    })

    // Máscara de números para labels e elementos de texto
    $(".textNumber").each((i, singleElement) => {
        maskTextNumber(singleElement);
    })

    // Formatação de números compactos
    $(".textNumberCompact").each((i, singleElement) => {
        maskElementNumberCompact(singleElement);
    })

    // Adiciona o simbolo de moeda
    $(".textMoneySymbol").each((i, singleElement) => {
        maskTextMoneySymbol(singleElement);
    })
}

// Carrega máscara de números com casas decimais e pontos de milhar para inputs
function maskElementNumber(element){
    let decimalPlaces = $(element).attr("decimalPlaces");

    if (typeof decimalPlaces == 'undefined' || decimalPlaces == null){
        decimalPlaces = 2;
    }  

    $(element).maskMoney({thousands: ".", decimal: ",", precision: decimalPlaces});
    element.value = element.value !== "" ? maskNumber(parseFloat(element.value), decimalPlaces) : "";
}

// Carrega máscara de números com casas decimais e pontos de milhar para labels e elementos de texto
function maskTextNumber(element){
    let decimalPlaces = $(element).attr("decimalPlaces");

    if (typeof decimalPlaces == 'undefined' || decimalPlaces == null){
        decimalPlaces = 2;
    }  

    let newValue = $(element).text() !== "" ? maskNumber(parseFloat($(element).text()), decimalPlaces) : "";

    $(element).text(newValue);
}

// Carrega o compactamento dos números
function maskElementNumberCompact(element){
    let compactValue = formatCompact($(element).text());

    $(element).text(compactValue);
}

function maskTextMoneySymbol(element) {
    let newValue = "R$ " + $(element).text();

    $(element).text(newValue);
}

// Retorna o número com as cadas decimais corretas
function maskNumber(value, decimalPlaces){
    return parseFloat(value.toFixed(decimalPlaces)).toLocaleString('pt-br', {minimumFractionDigits: decimalPlaces});
}

// Retira os pontos de milhar e define a vírgula da casa decimal como ponto
function unMaskNumber(value){
    return value.replace(/(\.)/g, '').replace(/,/g, '.');
}

// Autoload das máscaras
loadMasks();