var questConfig = {
    name: 'Тестовый квест 1',
    version: '0.0.1',
    templates: {
        0: {
            class: "Template",
            template: '<p>Вы прилетели на Цитадель. В доках было многолюдно, туда-сюда сновали челноки, причаливали и отчаливали корабли.</p>',             
        },
        1: {
            class: "Template",
            template: '<p>В посольствах, как всегда, полно представителей разных рас. Рядом была очередь в кабинет людей: посол Удина был явно чем-то сильно занят и не принимал гостей, из-за чего стоящие в очереди постоянно тыкали на кнопку, пытаясь пробиться в кабинет.</p>', 
        },
        2: {
            class: "Template",
            template: '<p>Вы едете в лифте Цитадели. На удивление, это современное средство передвижения ужасно медлительно, и вас уже начали раздражать непонятные разговоры ваших инопланетных попутчиков.</p>'
        },
        3: {
            class: "Template",
            template: '<p>Вы слишком долго тянули, и ожидавший вас контакт решил, что вы не явитесь на встречу. Миссия провалена</p>'
        },
        4: {
            class: "Template",
            template: '<div>{{{var1}}}.</div>{{#var2}}Прошло {{{var3}}} мин.{{/var2}}', 
            variables: {
                var1: 'quest.parameters[0].toString()', 
                var2: 'quest.parameters[1] > 0', 
                var3: 'quest.parameters[1]'
            }
        },
        5: {
            class: "Template",
            template: '<p>Напротив вас стоит лифт. Он может отвезти вас в другое место. Поездка займет {{var1}} минуты.</p>',
            variables: {var1: 'quest.constants[0]'}
        },
        6: {
            class: "Template",
            template: '<p>Вы едете в лифте Цитадели. Откуда-то сверху доносится тихая музычка, которая уже начала вам порядком надоедать...</p>'
        },
        7: {
            class: "Template",
            template: '<p>Вы зашли в лифт Цитадели. Когда дверь уже начала закрываться, вы увидели летящего к вам на всех парах гигантского крогана. Он буквально повесился на дверь, отчего та остановилась и то ли под тяжестью крогана, то ли под действием программы, начала опускаться обратно. Кроган запрыгнул в лифт с таким торжествующим видом и рыком, как будто совладал не с лифтом, а с целым молотильщиком. А на вас он смотрел как на недоеденный кусок пыжака.</p>'
        },
        8: {
            class: "Template",
            template: '<p>Вы едете в лифте, и это время пролетает незаметно, потому что вы буквально приклеились взглядом к стоящей в метре азари. Ваши мысли колебались между "Вот это си..." и "Интересно, сколько же ей лет?..".</p>'
        },
    },
    stages: {
        0: {
            class: "Stage",
            name: 'Доки',
            answers: [0],
            params: 4,
            type: 'start',
            templates: [0, 5],
            picture: 1,
            startAction: function () {
                quest.parameters[0].setValue(0);
            },
        },
        1: {
            class: "Stage",
            name: 'Посольства',
            answers: [1, 2],
            params: 4,
            type: 'medium',
            templates: [1, 5],
            picture: 2,
            startAction: function () {
                quest.parameters[0].setValue(1);
            },
        },
        2: {
            class: "Stage",
            name: 'Квест провален',
            answers: [3],
            params: 4,
            type: 'finish',
            templates: [3],
            picture: 2
        },
        3: {
            class: "Stage",
            name: 'Лифт',
            answers: [4],
            params: 4,
            type: 'medium',
            picture: 3,
            startAction: function () {
                this.text = [Game.random([2, 6, 7, 8])];
                quest.parameters[0].setValue(2);
            },
            finishAction: function () {
                quest.parameters[1].inc(quest.constants[0]);
                if (quest.parameters[1] >= 60) {
                    game.setStage(2, false); 
                    return false;
                }
                return true;
            }
        }
    },
    pictures: {
        0: {
            class: "Picture",
            filename: 'slider.jpg'
        },
        1: {
            class: "Picture",
            filename: 'docks.jpg'
        },
        2: {
            class: "Picture",
            filename: 'embassies.png'
        },
        3: {
            class: "Picture",
            filename: 'elevator.jpg'
        },
    },
    actions: {
        0: {
            class: "Action",
            name: 'В посольства',
            action: function (data)
            {
                quest.parameters[2].setValue(0);
                game.setStage(3);
            }
        },
        1: {
            class: "Action",
            name: 'В доки',
            action: function (data)
            {
                quest.parameters[2].setValue(1);
                game.setStage(3);
            }
        },
        2: {
            class: "Action",
            name: 'Квест провален',
            action: function (data)
            {
                game.finish();
            }
        },
        3: {
            class: "Action",
            name: 'В посольства',
            action: function (data)
            {
                game.setStage(quest.constants[1].valueOf()[quest.parameters[2].valueOf()]);
            }
        }
    },
    answers: {
        0: {
            class: 'Answer',
            text: 'В посольства',
            active: true,
            action: 0
        },
        1: {
            class: 'Answer',
            text: 'В доки',
            active: true,
            action: 1
        },
        2: {
            class: 'Answer',
            text: 'Разузнать',
            active: false,
            action: 1,
            icon: 'question'
        },
        3: {
            class: 'Answer',
            text: 'Квест провален',
            active: true,
            action: 2,
            icon: 'times'
        },
        4: {
            class: 'Answer',
            text: 'Выйти из лифта',
            active: true,
            action: 3
        },
    },
    parameters: {
        0: {
            class: 'EnumParameter',
            name: 'Местоположение персонажа',
            value: 0,
            enumList: {
                0: 'Вы в доках',
                1: 'Вы в посольствах',
                2: 'Вы в лифте',
            }
        },
        1: {
            class: 'NumberParameter',
            name: 'Прошедшее время с начала квеста (в минутах)',
            value: 0,
        },
        2: {
            class: 'EnumParameter',
            name: 'Назначение лифта',
            value: 0,
            enumList: {
                default: '',
                0: 'Посольства',
                1: 'Доки',
            },
            hidden: true,
        },
    },
    constants: {
        0: {
            class: "Constant",
            name: 'Время поездки',
            value: 3
        },
        1: {
            class: "Constant",
            name: 'Состояния, в которые ведет лифт',
            value: {
                0: 1,
                1: 0,
            }
        },
    }
};