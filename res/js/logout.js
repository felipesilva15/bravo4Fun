function logout(){
    cfgModal = modal.config();

    cfgModal.type = "CONFIRM";
    cfgModal.title = "Atenção";
    cfgModal.callback = () => {
        let request = api.request(`logout.php`, "GET");
    
        request
            .then((res) => {
                window.location.href = "views/login.html"
            })
            .catch((err) => {
                modal.close()

                cfgModalError = modal.config();

                cfgModalError.type = "CONFIRMCUSTOM";
                cfgModalError.title = "Atenção";
                cfgModalError.body = "Deseja mesmo fazer logout";

                modal.show(cfgModalError);
            });
    };

    modal.show(cfgModal);
}