function fileUpload(url, dir) {
	$('#fileupload').fileupload({
        url: url,
        dataType: 'json',
        formData: {dir: dir},
        done: function (e, data) { 
            $.each(data.files, function (index, file) {
                var template = twig({
                    href: '../../../jst/file-line.html.twig',
                    async: false,
                });
                var output = template.render({
                    file: file,
                    dir: dir
                });
                $('#files').append(output);
            });
            $('#progress').hide();
            $('#progress .progress-bar').css('width', '0%');
        },
        fail: function (e, data) {
            $.each(data.messages, function (index, error) {
                addNotification(error, 'error', 'topCenter');
            });
            $('#progress').hide();
            $('#progress .progress-bar').css('width', '0%');
        },
        progressall: function (e, data) {
            $('#progress').show();
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
}

function fileDelete() {
    $('#files').on('click', '.fDelete', function () {
        var ele = $(this);
        var file = ele.data('name');
        var dir = ele.data('dir');
        var response = noty({
            text: '<p><strong>¿Realmente desea eliminar el archivo?</strong></p>',
            layout: 'center',
            theme: 'relax',
            type: 'confirm',
            buttons: [
                {
                    addClass: 'btn btn-primary', text: 'Si', onClick: function($noty) {
                        $noty.close();
                        block('.block-file');
                        $.ajax({
                            url: Routing.generate('delete_api_file'),
                            type: "DELETE",
                            data: {file: file, dir: dir},
                            success: function (data) {
                                ele.parents('span').remove();
                                $('.block-file').unblock(); 
                            },
                            error: function() {
                                addNotification('Ha ocurrido un error', 'error', 'topCenter');
                            }
                        });
                    }
                },
                {
                    addClass: 'btn btn-danger', text: 'No', onClick: function($noty) {
                        $noty.close();
                    }
                }
            ]
        });
    });
}
