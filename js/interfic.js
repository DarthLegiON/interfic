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
 * @returns {unresolved}
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
    this._answers = [new Answer()];
    this._picture = null;
    this._params = [new Parameter()];
    this._questCode = questCode;
    this.init = document.createEvent('HTMLEvents');
    this.init.initEvent('init');
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
    this.setStage(0);
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
 * @param {type} text
 * @returns {undefined}
 */
Game.prototype.setText = function (text)
{
    this._text = text;
    var textElement = document.getElementById('text');
    var html = '';
    for (var i in text) {
        html += text[i].getBlock();
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
 * @param {type} stageId ID состояния
 * @returns {undefined}
 */
Game.prototype.setStage = function (stageId)
{
    this._currentStage = stageId;
    this.setText(Quest.stages[stageId].getTexts());
    this.setPicture(Quest.pictures[Quest.stages[stageId].pictureid]);
    this.setAnswers();
    this.setParams();
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
 * Отображает варианты действий
 * @returns {undefined}
 */
Game.prototype.setAnswers = function ()
{
    this._answers = Quest.stages[this._currentStage].answers;
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
        answerElement.innerHTML = answer.text;
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
    this._params = Quest.stages[this._currentStage].params;
    var paramsElement = document.getElementById('info');
    paramsElement.innerHTML = '';
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
 * @param {type} answers Массив ID ответов
 * @param {type} params Массив ID параметров
 * @param {type} type Тип (start, medium или finish, пока не используется)
 * @param {type} texts Массив ID текстов
 * @param {type} picture ID картинки
 * @returns {Stage}
 */
function Stage(answers, params, type, texts, picture)
{
    this.answers = getFuncParam(answers, [new Answer()]);
    this.params = getFuncParam(params, [new Parameter()]);
    this.type = getFuncParam(type, 'medium');
    this.texts = getFuncParam(texts, []);
    this.pictureid = getFuncParam(picture, 0);
}

/**
 * Выдает список текстов для текущего состояния
 * @returns {Array}
 */
Stage.prototype.getTexts = function ()
{
    var returnResult = [];
    for (var i in this.texts) {
        returnResult.push(Quest.texts[this.texts[i]]);
    }
    return returnResult;
};

//---------------------------------------------------------------------------

/**
 * Ответ, вариант действия.
 * @param {string} text текст ответа
 * @param {boolean} active активность
 * @param {number} action ID действия
 * @returns {Answer}
 */
function Answer(text, active, action)
{
    this.text = getFuncParam(text, 'Ответ');
    this.active = getFuncParam(active, true);
    this.actionid = getFuncParam(action, 0);
    this.action = null;
}

/**
 * Задает действие для ответа
 * @returns {undefined}
 */
Answer.prototype.setAction = function ()
{
    this.action = Quest.actions[this.actionid];
};

//---------------------------------------------------------------------------
/**
 * Картинка.
 * @param {type} name имя файла картинки, автоматически находится в папке images квеста
 * @returns {Picture}
 */
function Picture(name)
{
    this.name = name;
}


//---------------------------------------------------------------------------
/**
 * Абстрактный параметр
 * @param {string} type тип
 * @param {mixed} value значение по умолчанию
 * @param {string} prefix Префикс (то, что выводится перед значением)
 * @param {string} postfix постфикс (то, что выводится после значения)
 * @param {boolean} hidden true, если параметр не надо отображать в блоке параметров
 * @returns {Parameter}
 */
function Parameter(type, value, prefix, postfix, hidden)
{
    this._type = type;
    this._prefix = getFuncParam(prefix, null);
    this._postfix = getFuncParam(postfix, null);
    this.setValue(value);
    this.hidden = getFuncParam(hidden, false);
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
        string += (this._prefix !== null) ? this._prefix + ': ' : '';
        string += '<span>' + this._getTextValue() + '</span>';
        string += (this._postfix !== null) ? ' ' + this._postfix : '';
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
 * @param {type} value
 * @param {type} prefix
 * @param {type} postfix
 * @param {type} hidden
 * @returns {undefined}
 */
function TextParameter(value, prefix, postfix, hidden)
{
    TextParameter.superclass.constructor.call(this, 'text', value, prefix, postfix, hidden);
}

extend(TextParameter, Parameter);

//-------------------------------------------------
/**
 * Числовой параметр
 * @param {type} value
 * @param {string} prefix
 * @param {string} postfix
 * @param {array} rangeValues строки, соответствующие значениям параметра
 * @param {boolean} hidden
 * @returns {NumberParameter}
 */
function NumberParameter(value, prefix, postfix, rangeValues, hidden)
{
    NumberParameter.superclass.constructor.call(this, 'number', value, prefix, postfix, hidden);
    this._rangeValues = getFuncParam(rangeValues, null);
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
 * @param {type} val число, на которое нужно инкрементировать параметр
 * @returns {number}
 */
NumberParameter.prototype.inc = function (val)
{
    return this._value += val;
};

/**
 * Уменьшает значение параметра на val
 * @param {type} val число, на которое нужно декрементировать параметр
 * @returns {number}
 */
NumberParameter.prototype.dec = function (val)
{
    return this._value -= val;
};

/**
 * Параметр-перечисление
 * @param {type} value
 * @param {type} prefix
 * @param {type} postfix
 * @param {type} enumList массив строк, на которые надо заменить значение
 * @param {type} hidden
 * @returns {EnumParameter}
 */
function EnumParameter(value, prefix, postfix, enumList, hidden)
{
    EnumParameter.superclass.constructor.call(this, 'enum', value, prefix, postfix, hidden);
    this._enumList = getFuncParam(enumList, {default : ''});
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

//---------------------------------------------------------------------------
/**
 * Блок текста. Может быть целым тегом, началом тега, серединой или концом.
 * @param {string} text содержимое
 * @param {boolean} open true, если начинается открывающимся тегом
 * @param {boolean} close true, если заканчивается закрывающимся тегом
 * @param {string} tag имя тега
 * @param {string} style css-стиль
 * @returns {TextBlock}
 */
function TextBlock(text, open, close, tag, style)
{
    this._text = getFuncParam(text, '');
    this._open = getFuncParam(open, false);
    this._close = getFuncParam(close, open !== undefined);
    this._tag = getFuncParam(tag, 'p');
    this._style = getFuncParam(style, '');
    this._html = this._open && this._close;
}

/**
 * Является ли блок только открывающимся
 * @returns {Boolean}
 */
TextBlock.prototype.isOpen = function () {
    return this._open && !this._close;
};

/**
 * Является ли блок только закрывающимся
 * @returns {Boolean}
 */
TextBlock.prototype.isClose = function () {
    return this._close && !this._open;
};

/**
 * Геттер для tag
 * @returns {Boolean}
 */
TextBlock.prototype.tag = function () {
    return this._tag;
};

/**
 * Возвращает код блока вместе с тегом и содержимым
 * @returns {String}
 */
TextBlock.prototype.getBlock = function ()
{
    if (this._html) {
        var block = document.createElement(this._tag);
        block.className = this._style;
        block.innerHTML = this._text;
        return block.outerHTML;
    }
    else {
        if (this._open) {
            return '<' + this._tag
                    + ((this._style !== '') ? ' class="' + this._style + '" ' : '')
                    + '>' + this._text;
        } else if (this._close) {
            return this._text
                    + '</' + this._tag + '>';
        } else {
            return this._text;
        }

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

