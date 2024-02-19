const api = {};

let protocol = window.location.protocol;
let host = window.location.hostname;
let port = window.location.port && window.location.port != '' ? ':' + window.location.port : ''; 
let urlBase = `${protocol}//${host}${port}/`;

// Realiza uma requisição de um arquivo do projeto sem retornar um conjunto de dados
api.request = (url, method, data) => {
    const promisse = new Promise((resolve, reject) => {
        $.ajax({
            url: `${urlBase}${url}`,
            type: method,
            data: data,
            processData: false,
            contentType: false,
            headers: {
                'Cache-Control': 'no-cache, no-store, must-revalidate' 
            },
            success: (res) => {
                if (res === undefined) {
                    reject(res);
                    return;
                }

                // Tenta ler o JSON
                try {
                    res = JSON.parse(res);
                } catch (error) {
                    reject({ 
                        status: 500, 
                        title: "Erro inesperado",
                        message: "Tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador do seu sistema.", 
                        req: request,
                        items: error
                    });
                }

                // Inautorizado
                if (res.status == 403 && !res.items["showError"]){
                    window.location.href = "/views/login.html";
                }

                // Sucesso
                if (res.status < 400) {
                    resolve(res);
                    return;
                }

                // Ocorreu algum erro
                reject(res);
            },
            error: (request) => {
                reject({ 
                    status: 500, 
                    title: "Erro inesperado",
                    message: "Tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador do seu sistema.", 
                    req: request,
                    items: []
                });
            }
        })
    });

    return promisse;
};

api.requestArchive = (url, method, data) => {
    let errorModel = { 
        status: 500, 
        title: "Erro inesperado",
        message: "Tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador do seu sistema.", 
        items: []
    };

    const promisse = new Promise((resolve, reject) => {
        $.ajax({
            url: `${urlBase}${url}`,
            type: method,
            data: data,
            success: (res) => {
                if (res === undefined) {
                    reject(errorModel);
                    return;
                }

                if (res !== "") {
                    resolve(res);
                    return;
                }

                reject(errorModel);
            },
            error: (request) => {
                reject(errorModel);
            }
        })
    });

    return promisse;
};

// Realiza uma requisição de um arquivo do projeto retornando um conjunto de dados
api.consultar = (rota, method, data) => {

};
