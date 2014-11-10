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

Game.prototype.initialize = function ()
{
    //alert(Quest.name);
    //dispatchEvent(this.init);
    texts = [
        Quest.texts[0], Quest.texts[2], Quest.texts[1]//, Quest.texts[3]
    ];
    
    this.setText(texts);
};

Game.prototype._reQuest = function (questCode)
{
    var script = document.createElement('script');
    script.src = 'quests/' + questCode + '/quest.js';
    script.charset = 'UTF-8';
    var _this = this;
    script.onload = function ()
    {
        _this.initialize(Quest);
    };
    document.head.appendChild(script);
};

Game.prototype.setText = function (text)
{
    this._text = text;
    var textElement = document.getElementById('text');
    var html = ''
    for (var i in text) {
        html += text[i].getBlock();
    }
    textElement.innerHTML = html;
};

Game.prototype.setPicture = function (picture)
{
    this._picture = picture;
    document.getElementById('picture').innerHTML = '<img src="quests/' + this._questCode + '/images/' + picture.name + '">';
};

//---------------------------------------------------------------------------

function Stage()
{
    this.id = 0;
    this.answers = [new Answer()];
    this.params = [new Parameter()];
    this.type = 'medium';
}

//---------------------------------------------------------------------------

function Answer()
{

}

//---------------------------------------------------------------------------

function Picture()
{
    this.id = 0;
    this.name = '';
}

Picture.prototype.setName = function(name)
{
    this.name = name;
}

//---------------------------------------------------------------------------

function Parameter()
{

}

//---------------------------------------------------------------------------

function TextBlock(text, open, close, tag, style)
{
    this._text = (text === undefined) ? '' : text;
    this._open = (open === undefined) ? false : open;
    this._close = (close === undefined) ? true && (open !== undefined) : close;
    this._tag = (tag === undefined) ? 'p' : tag;
    this._style = (style === undefined) ? '' : style;
    this._html = open && close;
}

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
                + ((this._style !== '') ? 'class = "' + this._style + '" ' : '')
                + '>' + this._text;
        } else if (this._close) {
            return this._text
                + '</' + this._tag + '>';
        } else {
            return this._text;
        }
        
    }
}

TextBlock.prototype.isOpen = function () { return this._open && !this._close; }
TextBlock.prototype.isClose = function () { return this._close && !this._open; }

TextBlock.prototype.tag = function () { return this._tag; }

window.onload = function ()
{
    var game = new Game('quest1');
};

