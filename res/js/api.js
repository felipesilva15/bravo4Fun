const api = {};

// Realiza uma requisição de um arquivo do projeto sem retornar um conjunto de dados
api.request = (url, method, data) => {
    const promisse = new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: method,
            data: data,
            success: (res) => {
                if (res === undefined) {
                    reject(res);
                    return;
                }

                res = JSON.parse(res);

                if (res.status < 400) {
                    resolve(res);
                    return;
                }

                reject(res);
            },
            error: (request) => {
                reject({ 
                    status: 500, 
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
        message: "Tente novamente mais tarde. Caso o erro persista, entre em contato com o administrador do seu sistema.", 
        items: []
    };

    const promisse = new Promise((resolve, reject) => {
        $.ajax({
            url: url,
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
