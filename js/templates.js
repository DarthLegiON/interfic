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