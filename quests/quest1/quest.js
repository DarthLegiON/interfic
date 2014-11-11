var Quest = {
    name : 'Квест 1',

    texts : {
        0: new TextBlock('Абзац 1', true, true),
        1: new TextBlock('Вставка 1', true, true, 'span', 'gray'),
        2: new TextBlock('Начатый абзац 2 ', true, false),
        3: new TextBlock(' Окончание абзаца 2', false, true),
        4: new TextBlock('Абзац 5', true),
        5: new TextBlock('Абзац 6', true),
    },

    stages: {
        0: new Stage([0, 1], null, 'start', [2, 1, 3], 0)
    },
	
	pictures: {
		0: new Picture('slider.jpg')
	},
	
	actions: {
		0: function (data)
		{
			console.log(data);
		},
		1: function (data)
		{
			alert('экшн 1');
		}
	},
	
	answers: {
		0: new Answer(),
		1: new Answer()
	}
};