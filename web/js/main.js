/**
 * Created by Darth LegiON on 05.05.2015.
 */

$(document).on('ready', function () {
    $('input[type="checkbox"]').each(function () {
        if ($(this).next('label>i.fa').length !== 1) {
            $(this).next('label').prepend('<i class="fa fa-lg"></i>');
        }
    });
});