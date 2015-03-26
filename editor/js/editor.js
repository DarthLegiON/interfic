function onDocumentReady()
{
    $('input[type="checkbox"]').after('<i class="fa fa-lg"></i>');
}

$(document).on('ready',function () {
    onDocumentReady();
});