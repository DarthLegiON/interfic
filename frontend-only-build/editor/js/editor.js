/* global Menu, Editor */

function onDocumentReady()
{
    $('input[type="checkbox"]').after('<i class="fa fa-lg"></i>');
    Menu.render();
    if (Editor.questLoaded()) {
        Editor.openQuest(localStorage.quest);
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
        Editor.createQuest(form);
        Menu.jump('quest/info', {quest: Editor.questConfig});
    }
    
})

$(document).on('click', '#quest-close', function (e) {
    Editor.closeQuest();
});