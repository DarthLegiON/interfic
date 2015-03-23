/* global game */

var Quest = {
    name: 'Тестовый квест 1',
    version: '0.0.1',
    templates: {
        0: new Template({
            template: '<p>Вы прилетели на Цитадель. В доках было многолюдно, туда-сюда сновали челноки, причаливали и отчаливали корабли.</p> <p>Напротив вас стоит лифт. Он может отвезти вас в другое место. Поездка займет {{var1}} минуты.</p>', 
            variables: {var1: 'Quest.constants[0]'}
        }),
        1: new Template({
            template: '<p>Вы прилетели на Цитадель. В доках было многолюдно, туда-сюда сновали челноки, причаливали и отчаливали корабли.</p> <p>Напротив вас стоит лифт. Он может отвезти вас в другое место. Поездка займет {{var1}} минуты.</p>', 
            variables: {var1: 'Quest.constants[0]'}
        }),
        2: new Template({
            template: '<p>Вы едете в лифте Цитадели. На удивление, это современное средство передвижения ужасно медлительно, и вас уже начали раздражать непонятные разговоры ваших инопланетных попутчиков.</p>'
        }),
        3: new Template({
            template: '<p>Вы слишком долго тянули, и ожидавший вас контакт решил, что вы не явитесь на встречу. Миссия провалена</p>'
        }),
        4: new Template({
            template: '<div>{{{var1}}}.</div>{{#var2}}Прошло {{{var3}}} мин.{{/var2}}', 
            variables: {
                var1: 'Quest.parameters[0].toString()', 
                var2: '(Quest.parameters[1] > 0)', 
                var3: 'Quest.parameters[1]'
            }
        }),
    },
    stages: {
        0: new Stage({
            answers: [0],
            params: 4,
            type: 'start',
            templates: [0],
            picture: 1
        }),
        1: new Stage({
            answers: [1, 2],
            params: 4,
            type: 'medium',
            templates: [1],
            picture: 2
        }),
        2: new Stage({
            answers: [3],
            params: 4,
            type: 'finish',
            templates: [3],
            picture: 2
        }),
        3: new Stage({
            answers: [4],
            params: 4,
            type: 'medium',
            templates: [2],
            picture: 3
        })
    },
    pictures: {
        0: new Picture({
            filename: 'slider.jpg'
        }),
        1: new Picture({
            filename: 'docks.jpg'
        }),
        2: new Picture({
            filename: 'embassies.png'
        }),
        3: new Picture({
            filename: 'elevator.jpg'
        }),
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
        0: new Answer({
            text: 'В посольства',
            active: true,
            action: 0
        }),
        1: new Answer({
            text: 'В доки',
            active: true,
            action: 1
        }),
        2: new Answer({
            text: 'Разузнать',
            active: false,
            action: 1
        }),
        3: new Answer({
            text: 'Квест провален',
            active: true,
            action: 2
        }),
        4: new Answer({
            text: 'Выйти из лифта',
            active: true,
            action: 3
        }),
    },
    parameters: {
        0: new EnumParameter({
            value: 0,
            enumList: {
                0: 'Вы в доках',
                1: 'Вы в посольствах',
                2: 'Вы в лифте',
        }}),
        1: new NumberParameter({
            value: 0,
        }),
        2: new EnumParameter({
            value: 0,
            enumList: {
                default: '',
                0: 'Посольства',
                1: 'Доки',
            },
            hidden: true,
        }),
    },
    constants: {
        0: new Constant({
            name: 'Время поездки',
            value: 3
        })
    }
};