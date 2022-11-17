let request = api.request("validarCredenciais.php", "GET");

// Caso não dê em sucesso, significa que o mesmo não está autenticado
request
    .then((res) => {
    })
    .catch((err) => {
        window.location.href = "/bravo4Fun/views/login.html"
    });