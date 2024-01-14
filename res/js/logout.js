function logout(){
    cfgModal = modal.config();

    cfgModal.type = "confirmCustom";
    cfgModal.title = "Atenção";
    cfgModal.extra1 = "Deseja mesmo fazer logout?";
    cfgModal.callback = () => {
        let request = api.request(`logout.php`, "GET");
    
        request
            .then((res) => {
                window.location.href = "/bravo4Fun/views/login.html";
            })
            .catch((err) => {
                modal.close();

                cfgModalError = modal.config();

                cfgModalError.type = "error";
                cfgModalError.title = "Erro ao processar a solicitação";
                cfgModalError.body = err;

                modal.show(cfgModalError);
            });
    };

    modal.show(cfgModal);
}