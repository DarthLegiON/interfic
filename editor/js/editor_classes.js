var Menu = {
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

var Editor = {
    questLoaded: function ()
    {
        return (typeof localStorage.quest !== "undefined");
    }
};

function Form(config)
{
    /**
     * @type Object
     */
    this.rules = getFuncParam(config.rules, []);
    /**
     * @type String
     */
    this.selector = getFuncParam(config.selector, '');
    /**
     * @type Object
     */
    this.values = getFuncParam(config.values, $(this.selector).serializeObject());
}

Form.prototype.validate = function ()
{
    var success = true;
    for (var key in this.rules) {
         success = this._validateRule(this.rules[key]) && success;
    }
    return success;
};

Form.prototype._validateRule = function (rule)
{
    var value = this.values[rule.name];
    switch (rule.check) {
        case 'required':
            if (value.length === 0) {
                this._markError(rule);
                return false;
            } else {
                this._clearError(rule);
                return true;
            }
        default:
            return false;
    }
};

Form.prototype._findElement = function (name)
{
    return $(this.selector).find('[name="' + name + '"]');
};

Form.prototype._markError = function (rule)
{
    var element = this._findElement(rule.name);
    element.closest('.form-group').addClass('has-error');
    var messageBlock = $(element).nextAll('.validation-message-' + rule.check);
    if (messageBlock.length == 0) {
        var messageBlock = $('<div>').addClass('validation-message-' + rule.check + ' text-danger').text(getFuncParam(rule.message, 'Поле заполнено неправильно!'));
    }
    element.after(messageBlock);
};

Form.prototype._clearError = function (rule)
{
    var element = this._findElement(rule.name);
    var messageBlock = $(element).nextAll('.validation-message-' + rule.check);
    messageBlock.remove();
    if (element.nextAll('.text-danger').length === 0) {
        element.closest('.form-group').removeClass('has-error');
    }
};