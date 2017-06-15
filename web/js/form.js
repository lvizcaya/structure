$(document).ready(function() {
	if (!isMobile.any()) {
        $('input[type=date]').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true,
            todayHighlight: true
        });
    }

    if (!isMobile.any()) {
        $('input[type=time]').timepicker({
            showInputs: false,
            defaultTime: false,
            showMeridian: false
        });
    }

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });

    $('[data-intype="integer"]').inputmask("9999999999", {
        "placeholder": "",
        numericInput: false,
        allowMinus: false,
    });

    $('[data-intype="integerNum"]').inputmask("9999999999", {
        "placeholder": "",
        numericInput: true,
        allowMinus: false,
    });

    $('[data-intype="integerMinusNum"]').inputmask("9999999999", {
        "placeholder": "",
        numericInput: true,
        allowMinus: true,
    });

    $('[data-intype="decimal"]').inputmask("decimal", {
        allowMinus: false,
        digits: 2
    });

    $('[data-intype="decimalMinus"]').inputmask("decimal", {
        allowMinus: true,
        digits: 2
    });

    $('[data-intype="phone"]').inputmask("99999999999", {
        "placeholder": "",
        allowMinus: false,
    });

    $('[data-intype="imagePreview"]').change(function(e) {
            imagePreview(e, '#img_preview'); 
        });

    $('[data-intype="select2Simple"]').select2();

    $('[data-intype="select2Tags"]').select2({tags: true});

    $('[data-intype="range"]').daterangepicker({
        locale: {
              format: 'DD-MM-YYYY'
        }
    });
});
