function format (repo) {
    if (repo.loading) return repo.text;
    var markup = "<div class='select2-result-repository clearfix'>" +
    "<div class='select2-result-repository__name'>Matrícula: <strong>" + repo.name + "</strong></div></div>";
    return markup;
}

function formatSelection (repo) {
    if (repo.name) {return repo.name;}
    return repo.text;
}

$(document).ready(function() {
	$('#select_rid').select2({
        placeholder: $('#select_rid').data('placeh'),
        allowClear: true,
        language: "es",
        ajax: {
            url: Routing.generate('app_apiregister_cgetindustry'),
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    value: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; },
        minimumInputLength: 1,
        templateResult: format,
        templateSelection: formatSelection
    }).on('select2:select', function(e) {
        var id = $("#select_rid").val();
        $('#'+$('#select_rid').data('form')+'_rid').val(id);
    });
});
