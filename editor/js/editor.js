/* global Menu, Editor */

function onDocumentReady()
{
    $('input[type="checkbox"]').after('<i class="fa fa-lg"></i>');
    Menu.render();
    if (Editor.questLoaded()) {
        Menu.jump('quest/info', {quest: localStorage.quest});
    } else {
        Menu.jump('start');
    }
}

$(document).on('ready',function () {
    onDocumentReady();
});

$(document).on('click', '.nav a:not([data-toggle="dropdown"])', function (e) {
    e.preventDefault();
    Menu.jump($(this).attr('href'));
});

$(document).on('submit', 'form#quest-create-form', function (e) {
    e.preventDefault();
    var form = new Form({
        selector: '#' + $(this).attr('id'),
        rules: [
            {
                name: 'name',
                check: 'required',
            }
        ]
    });
    if (form.validate()) {
        var quest = new Quest({
            name: form.values.name,
            version: '0.0.1'
        });
        localStorage.setItem('quest', quest);
        Menu.jump('quest/info', {quest: localStorage.quest});
    }
    
})