function Game(questCode)
{
    this._reQuest(questCode);
}

Game.prototype.init = function ()
{
    alert(Quest.name);
}

Game.prototype._reQuest = function (questCode)
{
    var script = document.createElement('script');
    script.src = 'quests/' + questCode + '/quest.js';
    script.charset = 'UTF-8';
    var _this = this;
    script.onload = function ()
    {
        _this.init(Quest);
    };
    document.head.appendChild(script);
};