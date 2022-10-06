let request = api.request("validarCredenciais.php", "GET");

// Caso não dê em sucesso, significa que o mesmo não está autenticado
request
    .then((res) => {
        console.log(res);
    })
    .catch((err) => {
        console.log(err);
        window.location.href = "/bravo4Fun/login.html"
    });