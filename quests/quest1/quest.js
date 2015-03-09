/* global game */

var Quest = {
    name: 'Тестовый квест 1',
    version: '0.0.1',
    texts: {
        0: new TextBlock('Вы прилетели на Цитадель. В доках было многолюдно, туда-сюда сновали челноки, причаливали и отчаливали корабли.', true, true),
        1: new TextBlock('посольство', true, true, 'span', 'blue'),
        2: new TextBlock('Напротив вас стоит лифт. Он может отвезти вас в ', true, false),
        3: new TextBlock('. Поездка займет три минуты.', false, true),
        4: new TextBlock('В посольствах, как всегда, полно представителей разных рас. Рядом была очередь в кабинет людей: посол Удина был явно чем-то сильно занят и не принимал гостей, из-за чего стоящие в очереди постоянно тыкали на кнопку, пытаясь пробиться в кабинет.', true),
        5: new TextBlock('Абзац 6', true),
        6: new TextBlock('доки', true, true, 'span', 'blue'),
        7: new TextBlock('Вы слишком долго тянули, и ожидавший вас контакт решил, что вы не явитесь на встречу. Миссия провалена', true, true),
        8: new TextBlock('Вы едете в лифте Цитадели. На удивление, эта современное средство передвижения ужасно медлительно, и вас начинает раздражать непонятные разговоры ваших попутчиков.', true, true)
    },
    stages: {
        0: new Stage([0], [0, 1], 'start', [0, 2, 1, 3], 1),
        1: new Stage([1, 2], [0, 1], 'medium', [4, 2, 6, 3], 2),
        2: new Stage([3], [0, 1], 'finish', [7], 2),
        3: new Stage([4], [0, 1], 'medium', [8], 3)
    },
    pictures: {
        0: new Picture('slider.jpg'),
        1: new Picture('docks.jpg'),
        2: new Picture('embassies.png'),
        3: new Picture('elevator.jpg'),
    },
    actions: {
        0: function (data)
        {
            Quest.parameters[0].setValue(2);
            Quest.parameters[2].setValue(0);
            game.setStage(3);
        },
        1: function (data)
        {
            Quest.parameters[0].setValue(2);
            Quest.parameters[2].setValue(1);
            game.setStage(3);
        },
        2: function (data)
        {
            game.finish();
        },
        3: function (data)
        {
            Quest.parameters[1].inc(3);
            if (Quest.parameters[1] >= 60) {
                game.setStage(2); return;
            }
            switch (Quest.parameters[2].valueOf()) {
                case 0:
                    Quest.parameters[0].setValue(1);
                    game.setStage(1);
                    break;
                case 1:
                    Quest.parameters[0].setValue(0);
                    game.setStage(0);
                    break;
            } 
        }
    },
    answers: {
        0: new Answer('В посольства', true, 0),
        1: new Answer('В доки', true, 1),
        2: new Answer('Разузнать', false, 1),
        3: new Answer('Квест провален', true, 2),
        4: new Answer('Выйти из лифта', true, 3),
    },
    parameters: {
        0: new EnumParameter(0, null, null, {
            0: 'Вы в доках',
            1: 'Вы в посольствах',
            2: 'Вы в лифте',
        }),
        1: new NumberParameter(0, 'Прошло', 'мин', null),
        2: new EnumParameter(0, null, null, {
            default: '',
            0: 'Посольства',
            1: 'Доки',
        }, true),
    },
};