function select2LoadConfig() {
    const dataSeparator = ' - ';

    $('.select2AutoConfig').each((i, singleElement) => {
        var request = api.request(`select2Load.php?select2ConfigName=${$(singleElement).attr("select2Config")}`, 'GET' );

        request
            .then((res) => {
                let data = res.items[0];

                data.forEach(item => {
                    $(singleElement).append(`<option value="${item.ID}">${item.ID + dataSeparator + item.NAME}</option>`);
                })
            })
            .catch((err) => {
                console.log(err);
            });
    });
}

$(document).ready(function() {
    // Config select2
    $('.select2AutoConfig').select2({
        theme: 'bootstrap-5'
    });

    // Fixing auto-focus after select2 open
    $('.select2AutoConfig').on('select2:open', function(e) {
        let selectSearchInputs = $(".select2-search__field");

        if(selectSearchInputs){
            selectSearchInputs[0].focus();
        }
    });

    // Autoload select2 options
    select2LoadConfig();
});