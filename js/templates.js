/* global Mustache */
/* global Quest */

/**
 * Шаблон
 * @param {Array} config
 * @returns {Template}
 */
function Template(config)
{
    /**
     * @type String
     */
    this._template = getFuncParam(config.template, '');
    
    /**
     * @type Array
     */
    this._variables = getFuncParam(config.variables, {});
}

/**
 * Генерирует HTML-код из шаблона
 * @returns {undefined}
 */
Template.prototype.render = function ()
{
    
    return Mustache.render(this._template, this._getVariablesValues());
};

Template.prototype._getVariablesValues = function ()
{
    var result = {};
    for (var code in this._variables) {
        result[code] = eval(this._variables[code]);
    }
    
    return result;
};


function UrlTemplate(config)
{
    if (typeof config.url !== 'undefined') {
        this._url = config.url;
        this._getFromUrl();
        this._afterLoad = getFuncParam(config.afterLoad, function () { });
    }
}

extend(UrlTemplate, Template);


UrlTemplate.prototype._getFromUrl = function ()
{
    if (window['$'] !== undefined) {
        var path = 'templates/' + this._url + '.html';
        var _this =  this;
        $.get(path, null, function (data) {
            _this._template = data;
            _this._afterLoad();
        });
    } else {
        this._template = '';
    }
};