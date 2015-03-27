/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Menu = {
    jump: function (href)
    {
        var split = href.split('/');
        var block = $('#main_container');
        var blocks = $('.block');
        blocks.hide();
        for (var i in split) {
            block = block.children('.block.block-' + split[i]);
            block.show();
        }
    }
};