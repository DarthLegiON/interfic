/**
 * Created by Darth LegiON on 05.05.2015.
 */

$(document).on('ready', function () {

    $('input[type="checkbox"], input[type="radio"]').each(function () {
        if ($(this).next('label').length == 1 && $(this).next('label>i.fa').length !== 1) {
            $(this).next('label').prepend('<i class="fa fa-lg"></i>');
        }
        if ($(this).parent('label').length == 1 && $(this).next('i.fa') !== 1) {
            $(this).after('<i class="fa fa-lg"></i>');
        }
    });
});