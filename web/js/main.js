/**
 * Created by Darth LegiON on 05.05.2015.
 */

$(document).on('ready', function () {

    // Перезапись стандартного окна confirm в yii
    yii.confirm = function(message, ok, cancel) {
        bootbox.confirm(message, function(result) {
            if (result) { !ok || ok(); } else { !cancel || cancel(); }
        });
    };

    // Включение тултипов и поповеров
    $("[data-toggle='tooltip']").tooltip();
    $("[data-toggle='popover']").popover();

    // Чекбоксы и радиобатоны, TODO: заменить на что-нибудь библиотечное
    $('input[type="checkbox"], input[type="radio"]').each(function () {
        if ($(this).next('label').length == 1 && $(this).next('label>i.fa').length !== 1) {
            $(this).next('label').prepend('<i class="fa fa-lg"></i>');
        }
        if ($(this).parent('label').length == 1 && $(this).next('i.fa') !== 1) {
            $(this).after('<i class="fa fa-lg"></i>');
        }
    });
});

$(document).on('click', 'a[href][disabled]', function (e) {
    e.preventDefault();
});