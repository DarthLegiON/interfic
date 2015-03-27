Menu = {
    jump: function (href, params)
    {
        
        var block = $('#main_container');
        var template = new UrlTemplate({
            url: href,
            variables: getFuncParam(params, {}),
            afterLoad: function () {
                block.html(template.render());
            }
        });
    },
    render: function (activeItem)
    {
        var params = undefined;
        var template = new UrlTemplate({
            url: 'mainmenu',
            variables: getFuncParam(params, {}),
            afterLoad: function () {
                $('body').prepend(template.render());
            }
        });
    }
};