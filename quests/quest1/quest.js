/* global game */

var Quest = {
    name: 'Тестовый квест 1',
    version: '0.0.1',
    texts: {
        0: new TextBlock('Вы прилетели на Цитадель. В доках было многолюдно, туда-сюда сновали челноки, причаливали и отчаливали корабли.', true, true),
        1: new TextBlock('посольство', true, true, 'span', 'yellow'),
        2: new TextBlock('Напротив вас стоит лифт. Он может отвезти вас в ', true, false),
        3: new TextBlock('. Поездка займет три минуты.', false, true),
        4: new TextBlock('В посольствах, как всегда, полно представителей разных рас. Рядом была очередь в кабинет людей: посол Удина был явно чем-то сильно занят и не принимал гостей, из-за чего стоящие в очереди постоянно тыкали на кнопку, пытаясь пробиться в кабинет.', true),
        5: new TextBlock('Абзац 6', true),
        6: new TextBlock('доки', true, true, 'span', 'yellow'),
        7: new TextBlock('Вы слишком долго тянули, и ожидавший вас контакт решил, что вы не явитесь на встречу. Миссия провалена', true, true)
    },
    stages: {
        0: new Stage([0], [0, 1], 'start', [0, 2, 1, 3], 1),
        1: new Stage([1, 2], [1], 'medium', [4, 2, 6, 3], 2),
        2: new Stage([3], [1], 'finish', [7], 2)
    },
    pictures: {
        0: new Picture('slider.jpg'),
        1: new Picture('docks.jpg'),
        2: new Picture('embassies.png')
    },
    actions: {
        0: function (data)
        {
            Quest.parameters[1].setValue(Quest.parameters[1].getValue() + 3);
            if (Quest.parameters[1] !== 0) {
                Quest.parameters[1].show();
            }
            if (Quest.parameters[1].getValue() >= 60) {
                game.setStage(2);
            } else {
                game.setStage(1);
            }
        },
        1: function (data)
        {
            Quest.parameters[1].setValue(Quest.parameters[1].getValue() + 3);
            if (Quest.parameters[1].getValue() >= 60) {
                game.setStage(2);
            } else {
                game.setStage(0);
            }
        },
        2: function (data)
        {
            game.finish();
        }
    },
    answers: {
        0: new Answer('В посольство', true, 0),
        1: new Answer('В доки', true, 1),
        2: new Answer('Разузнать', false, 1),
        3: new Answer('Квест провален', true, 2),
    },
    parameters: {
        0: new TextParameter('Вы стоите у своего корабля'),
        1: new NumberParameter(0, 'Прошло', 'мин', null, true),
    },
};