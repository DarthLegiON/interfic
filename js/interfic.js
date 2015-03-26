/* global Quest */

var game;

/**
 * Наследует один класс от другого
 * @param {Object} Child Класс-наследник
 * @param {Object} Parent Класс-родитель
 * @returns {undefined}
 */
function extend(Child, Parent)
{
    var F = function () {
    };
    F.prototype = Parent.prototype;
    Child.prototype = new F();
    Child.prototype.constructor = Child;
    Child.superclass = Parent.prototype;
}

/**
 * Заменяет значение параметра на умолчание, если оно undefined
 * @param {type} param параметр
 * @param {type} def значение по умолчанию
 * @returns {@type param}
 */
function getFuncParam(param, def)
{
    return (param === undefined) ? def : param;
}

//-----------------------------------------------------------------------------------
/**
 * Класс "Игра", основной класс.
 * Конструктор начинает игру, основываясь на коде квеста
 * @param {string} questCode код квеста
 * @returns {Game}
 */
function Game(questCode)
{

    this._text = [];
    this._answers = [new Answer({})];
    this._picture = null;
    this._params = [new Parameter({})];
    this._questCode = questCode;
    /*this.init = document.createEvent('HTMLEvents');
    this.init.initEvent('init');*/
    this._reQuest(questCode);

}

/**
 * Запускает квест
 * @returns {undefined}
 */
Game.prototype.initialize = function ()
{
    //alert(Quest.name);
    //dispatchEvent(this.init);
    this.setStage(0, false);
    this.showQuestInfo();
};

/**
 * Предзагружает картинки на страницу, чтобы закешировать их и затем мгновенно загружать в блок картинок
 * @returns {undefined}
 */
Game.prototype.preloadPictures = function ()
{
    var preloadCont = document.getElementById('preload_pictures');
    for (var i in Quest.pictures) {
        var image = document.createElement('img');
        image.src = 'quests/' + this._questCode + '/images/' + Quest.pictures[i].name;
        preloadCont.appendChild(image);
    }
};

/**
 * Загружает JS-код квеста
 * @param {string} questCode
 * @returns {undefined}
 */
Game.prototype._reQuest = function (questCode)
{
    var script = document.createElement('script');
    script.src = 'quests/' + questCode + '/quest.js';
    script.charset = 'UTF-8';
    var _this = this;
    script.onload = function ()
    {
        _this.preloadPictures();
        _this.initialize(Quest);
    };
    document.head.appendChild(script);
};

/**
 * Отображает информацию о квесте (название и версию) в специальном блоке
 * @returns {undefined}
 */
Game.prototype.showQuestInfo = function ()
{
    var questInfo = document.getElementById('questinfo');
    if (questInfo !== undefined) {
        var questName = document.createElement('span');
        questName.innerHTML = Quest.name;
        questName.className = 'quest-name';
        questInfo.appendChild(questName);

        var questVer = document.createElement('span');
        questVer.innerHTML = ' v' + Quest.version;
        questVer.className = 'quest-version';
        questInfo.appendChild(questVer);
    }
};

/**
 * Устанавливает текст в блок для текста
 * @param {Array[Template]} texts
 * @returns {undefined}
 */
Game.prototype.setText = function (texts)
{
    this._text = texts;
    
    var textElement = document.getElementById('text');
    var html = '';
    for (var i in texts) {
        html += Quest.templates[texts[i]].render();
    }
    textElement.innerHTML = html;
};

/**
 * Изменяет картинку в блоке для картинки
 * @param {type} picture
 * @returns {undefined}
 */
Game.prototype.setPicture = function (picture)
{
    this._picture = picture;
    document.getElementById('picture').innerHTML = '<img src="quests/' + this._questCode + '/images/' + picture.name + '">';
};

/**
 * Меняет состояние квеста
 * @param {Number} stageId ID состояния
 * @param {Boolean} doFinish проверять ли окончание состояния, по умолчанию true
 * @returns {undefined}
 */
Game.prototype.setStage = function (stageId, doFinish)
{
    doFinish = getFuncParam(doFinish, true);
    if (!doFinish || this._currentStage.finishAction()) {
        this._currentStage = Quest.stages[stageId];
        this._currentStage.startAction();
        this.setText(Quest.stages[stageId].getText());
        this.setPicture(Quest.pictures[Quest.stages[stageId].pictureid]);
        this.setAnswers();
        this.setParams();
    }    
    
};

/**
 * Завершает квест
 * @returns {undefined}
 */
Game.prototype.finish = function ()
{
    if (confirm('Игра закончена! Попробовать еще раз?')) {
        document.location.reload();
    } else {
        // do smth
    }
};

/**
 * Выдает случайные значения из списка 
 * @param {Array} array список
 * @param {Number} count количество (если нужно одно, можно не указывать, функция вернет не массив, а значение)
 * @param {Boolean} repeat нужны ли повторения
 * @returns {Array|Number}
 */
Game.random = function (array, count, repeat)
{
    /**
     * 
     * @type {Array}
     */
    var _array = getFuncParam(array, []);
    var _count = getFuncParam(count, 1);
    var _repeat = getFuncParam(repeat, false);
    var arrCount = _array.length;
    if (_count > 0 && arrCount > 0 && _count <= arrCount) {
        if (_count === 1) {
            var rand = Math.floor(Math.random() * (arrCount));
            return array[rand];
        } else {
            var result = [];
            var indexes = [];
            var rand = 0;
            for (var i = 0; i < _count; i++) {
                rand = Math.floor(Math.random() * (arrCount));
                while (indexes.indexOf(rand) !== -1 && !_repeat) {
                    rand = Math.floor(Math.random() * (arrCount));
                }
                indexes.push(rand);
                result.push(_array[rand]);
            }
            return result;
        }
    } else {
        return null;
    }
};

/**
 * Отображает варианты действий
 * @returns {undefined}
 */
Game.prototype.setAnswers = function ()
{
    this._answers = this._currentStage.answers;
    var answersElement = document.getElementById('answers');
    answersElement.innerHTML = '';
    for (var i in this._answers) {
        var answer = Quest.answers[this._answers[i]];
        var answerElement = document.createElement('a');
        answerElement.className = 'answer';
        if (answer.active) {
            answerElement.classList.add('active');
            answerElement.href = 'javascript://';
            answerElement.onclick = Quest.actions[answer.actionid];
        }
        answerElement.innerHTML = answer.getText();
        answersElement.appendChild(answerElement);
        //html += answerElement.outerHTML;
    }
    //answersElement.innerHTML = html;
};

/**
 * Отображает параметры
 * @returns {undefined}
 */
Game.prototype.setParams = function ()
{
    this._params = this._currentStage.params;
    var paramsElement = document.getElementById('info');
    paramsElement.innerHTML = Quest.templates[this._params].render();
    for (var i in this._params) {
        var param = Quest.parameters[this._params[i]];
        var paramElement = document.createElement('div');
        paramElement.className = 'param';
        paramElement.innerHTML = param;
        paramsElement.appendChild(paramElement);
    }
};

//---------------------------------------------------------------------------

/**
 * Состояние квеста. Отвечает за набор параметров, 
 * @param {Array} config 
 * @returns {Stage}
 */
function Stage(config)
{
    this.answers = getFuncParam(config.answers, []);
    this.params = getFuncParam(config.params, []);
    this.type = getFuncParam(config.type, 'medium');
    this.text = getFuncParam(config.templates, []);
    this.pictureid = getFuncParam(config.picture, 0);
    this.startAction = getFuncParam(config.startAction, function () { });
    this.finishAction = getFuncParam(config.finishAction, function () { return true; });
}

/**
 * Выдает список текстов для текущего состояния
 * @returns {Template}
 */
Stage.prototype.getText = function ()
{
    var result = [];
    for (var i in this.text) {
        result.push(this.text[i]);
    }
    return result;
};

//---------------------------------------------------------------------------

/**
 * Ответ, вариант действия.
 * @param {Array} config 
 * @returns {Answer}
 */
function Answer(config)
{
    this.text = getFuncParam(config.text, 'Ответ');
    this.active = getFuncParam(config.active, true);
    this.actionid = getFuncParam(config.action, 0);
    this.action = null;
    this.icon = getFuncParam(config.icon, 'angle-right');
}

/**
 * Задает действие для ответа
 * @returns {undefined}
 */
Answer.prototype.setAction = function ()
{
    this.action = Quest.actions[this.actionid];
};

Answer.prototype.getText = function ()
{
    return '&nbsp;<i class="fa fa-' + this.icon + '"></i>&nbsp;' + this.text;
};

//---------------------------------------------------------------------------
/**
 * Картинка.
 * @param {Array} config
 * @returns {Picture}
 */
function Picture(config)
{
    this.name = config.filename;
}


//---------------------------------------------------------------------------
/**
 * Абстрактный параметр
 * @param {Array} config 
 * @returns {Parameter}
 */
function Parameter(config)
{
    this._prefix = getFuncParam(config.prefix, null);
    this._postfix = getFuncParam(config.postfix, null);
    this.setValue(config.value);
    this.hidden = getFuncParam(config.hidden, false);
}

/**
 * 
 * @param {type} value
 * @returns {undefined}
 */
Parameter.prototype.setValue = function (value)
{
    this._value = value;
};

/**
 * Перегруженный метод, выдает значение.
 * @returns {number}
 */
Parameter.prototype.valueOf = function ()
{
    return this._value;
};

/**
 * Перегружает метод toString. Выдает текстовое представление параметра (с префиксом, постфиксом и кодами)
 * @returns {String}
 */
Parameter.prototype.toString = function ()
{
    var string = '';
    if (!(this.hidden)) {
        string += '<span>' + this._getTextValue() + '</span>';
    }
    return string;
};

/**
 * Выдает текстовое представление параметра. Перегружается в более конкретных типах параметров
 * @returns {string}
 */
Parameter.prototype._getTextValue = function ()
{
    return this._value;
};

/**
 * Показывает параметр
 * @returns {undefined}
 */
Parameter.prototype.show = function ()
{
    this.hidden = false;
};

/**
 * Скрывает параметр
 * @returns {undefined}
 */
Parameter.prototype.hide = function ()
{
    this.hidden = true;
};

//-------------------------------------------------
/**
 * Параметр в виде текста. Фактически ничем не отличается от базового.
 * @param {Array} config
 * @returns {undefined}
 */
function TextParameter(config)
{
    TextParameter.superclass.constructor.call(this, config);
}

extend(TextParameter, Parameter);

//-------------------------------------------------
/**
 * Числовой параметр
 * @param {Array} config
 * @returns {NumberParameter}
 */
function NumberParameter(config)
{
    NumberParameter.superclass.constructor.call(this, config);
    this._rangeValues = getFuncParam(config.rangeValues, null);
}

extend(NumberParameter, Parameter);

/**
 * Перегруженый метод, @see Parameter
 * @returns {string}
 */
NumberParameter.prototype._getTextValue = function ()
{
    if (this._rangeValues !== null) {
        return this._getRange();
    } else {
        if ((this._value) % 1 === 0) {
            return this._value.toString();
        } else {
            return this._value.toFixed(2).toString();
        }
    }
};

/**
 * Если у параметра заданы текстовые аналоги значений, выдает их.
 * @returns {string}
 */
NumberParameter.prototype._getRange = function ()
{
    for (var index in this._rangeValues) {
        if (this._value >= index) {
            return this._rangeValues[index];
        }
    }
    return this._rangeValues.default;
};

/**
 * Увеличивает значение параметра на val
 * @param {Number} val число, на которое нужно инкрементировать параметр
 * @returns {Number}
 */
NumberParameter.prototype.inc = function (val)
{
    return this._value += val;
};

/**
 * Уменьшает значение параметра на val
 * @param {Number} val число, на которое нужно декрементировать параметр
 * @returns {Number}
 */
NumberParameter.prototype.dec = function (val)
{
    return this._value -= val;
};

/**
 * Параметр-перечисление
 * @param {Array} config
 * @returns {EnumParameter}
 */
function EnumParameter(config)
{
    EnumParameter.superclass.constructor.call(this, config);
    this._enumList = getFuncParam(config.enumList, {default : ''});
}

extend(EnumParameter, Parameter);

/**
 * Перегруженый метод, @see Parameter
 * @returns {string}
 */
EnumParameter.prototype._getTextValue = function ()
{
    for (var index in this._enumList) {
        if (this._value == index) {
            return this._enumList[index];
        }
    }
    return this._enumList.default;
};

function Constant(config)
{
    this._name = getFuncParam(config.name, '');
    this._value = getFuncParam(config.value, null);
}

Constant.prototype.valueOf = function ()
{
    return this._value;
};

Constant.prototype.toString = function ()
{
    switch (typeof this._value) {
        case 'string':
        case 'number':
            return this._value;
    }
};


/**
 * Запуск игры.
 * @returns {undefined}
 */
window.onload = function ()
{
    game = new Game('quest1');
};

