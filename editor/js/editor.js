/* global Menu */

function onDocumentReady()
{
    $('input[type="checkbox"]').after('<i class="fa fa-lg"></i>');
    
    Menu.jump('start');
}

$(document).on('ready',function () {
    onDocumentReady();
});

$(document).on('click', '.nav a:not([data-toggle="dropdown"])', function (e) {
    e.preventDefault();
    Menu.jump($(this).attr('href'));
});