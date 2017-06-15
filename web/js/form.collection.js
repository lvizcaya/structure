var $collectionHolder;

var $addLink = $('<a href="#" class="add_link btn btn-default btn-flat"><i class="fa fa-plus"></i></a>');
var $newLink = $('<div class="add_link_form_collection"></div>').append($addLink);

function addFormDeleteLink($formLine, $con) {
    var $removeFormLink = $('<a href="#" class="btn btn-box-tool"><i class="fa fa-remove"></i></a>');
    $formLine.append($removeFormLink);
    $removeFormLink.on('click', function(e) {
        e.preventDefault();
        $con.remove();
    });
}

function addForm($collectionHolder, $newLink, $delete = true) {
    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);
    var $newFormLine = $('<div class="con"></div>').append(newForm);
    var $del = $newFormLine.find('.del');
    $newLink.before($newFormLine);
    if ($delete == true) { addFormDeleteLink($del, $newFormLine); }
    $('[data-intype="select2Simple"]').select2();
}

jQuery(document).ready(function() {
    $collectionHolder = $('div.collection');

    $collectionHolder.find('div.con').each(function(index, value) {
        var $del = $(this).find('.del');
        if (index > 0) { addFormDeleteLink($del, $(this)); }
    });

    $collectionHolder.append($newLink);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addLink.on('click', function(e) {
        e.preventDefault();
        addForm($collectionHolder, $newLink);
    });
});
