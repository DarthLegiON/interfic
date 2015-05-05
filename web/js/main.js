/**
 * Created by Darth LegiON on 05.05.2015.
 */

$(document).on('ready', function () {
    $('input[type="checkbox"]').each(function () {
        if ($(this).next('i.fa').length !== 1) {
            $(this).after('<i class="fa fa-lg"></i>');
        }
    });
});