/* global Mustache */
/* global Quest */

/**
 * Шаблон
 * @param {String} template
 * @param {Array} variables
 * @returns {Template}
 */
function Template(template, variables)
{
    /**
     * @type String
     */
    this._template = getFuncParam(template, '');
    
    /**
     * @type Array
     */
    this._variables = getFuncParam(variables, {});
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
        return eval(this._variables[code]);
    }
    
    return result;
};