// Para que o formulário funcione juntamente com a API, basta seguir os passos abaixo:
// 1º Importe script "forms.js"
// 2º Altere o id do botão para "btnOk"
// 3º Altere o id do form para "form-js"
// 4º Adicione o atributo "redirect" com o valor sendo o local para onde o JS deve redirecionar caso dê tudo certo
$("#btnOk").on("click", (e) => {
    e.preventDefault()

    buttonAnimate.initAnimation($('#btnOk'));

    let form, data;

    form = document.querySelector("#form-js");

    if (!form.checkValidity()) {
        e.stopPropagation();

        form.classList.add('was-validated');
        buttonAnimate.releaseAnimation($('#btnOk'));

        return;
    }

    form = $("#form-js");

    if(form.attr("method").toUpperCase() == "POST"){
        data = new FormData(document.querySelector("#form-js"));
    } else{
        data = form.serialize();
    }
    
    let request = api.request(form.attr("action"), form.attr("method"), data);

    request
        .then((res) => {
            if(form.attr("redirect") && form.attr("redirect") !== ""){
                window.location.href = `/${form.attr("redirect")}`;
            }
        })
        .catch((err) => {
            cfgModalError = modal.config();

            cfgModalError.type = "error";
            cfgModalError.title = "Atenção";
            cfgModalError.body = err;

            modal.show(cfgModalError);
        })
        .finally(() => {
            buttonAnimate.releaseAnimation($('#btnOk'));
        });
});