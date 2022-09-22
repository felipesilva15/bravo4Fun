const api = {};

// Realiza uma requisição de um arquivo do projeto sem retornar um conjunto de dados
api.request = (url, method, data) => {
    const promisse = new Promise((resolve, reject) => {
        // Instancia objeto XMLHttoRequest
        let xhr = new XMLHttpRequest();

        // Abre a requisição
        xhr.open(method, url);

        // Caso a requisição tenha que enviar um body, define o cabeçalho de content-type
        if(data){
            xhr.setRequestHeader("Content-Type", "application/json; charset=utf-8");
        }
        
        // Quando carregar, executa uma função 
        xhr.onload = () => {
            // Caso o stauts seja maior ou igual à 400, acusa como erro, senão, retorna os dados obtidos
            if(xhr.status >= 400 || JSON.parse(xhr.response).status >= 400){
                reject(JSON.parse(xhr.response));
            } else{
                resolve(JSON.parse(xhr.response));
            }
        }

        // Caso ocorra um rerro na requisição, acusa como erro 
        xhr.onerror = () => {
            reject(JSON.parse({
                status: 500, 
                message: "Erro ao consumir a API.", 
                items: []
            }))
        }

        // Envia os dados do body em JSON
        xhr.send(JSON.stringify(data));
    });

    return promisse;
};

// Realiza uma requisição de um arquivo do projeto retornando um conjunto de dados
api.consultar = (rota, method, data) => {

};
