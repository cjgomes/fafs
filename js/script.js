jQuery.noConflict();
(function($) {
    $(function() {
        /*** Dropdown menu ***/
        
        var timeout    = 200;
        var closetimer = 0;
        var ddmenuitem = 0;

        function dd_open() {
            dd_canceltimer();
            dd_close();
            var liwidth = $(this).width();
            ddmenuitem = $(this).find('ul').css({'visibility': 'visible', 'width': liwidth});
            ddmenuitem.prev().addClass('main-menu_hover').parent().addClass('main-menu_hover');
        }

        function dd_close() {
            if(ddmenuitem) ddmenuitem.css('visibility', 'hidden').prev().removeClass('main-menu_hover').parent().removeClass('main-menu_hover');
        }

        function dd_timer() {closetimer = window.setTimeout(dd_close, timeout);
        }

        function dd_canceltimer() {
            if (closetimer) {
                window.clearTimeout(closetimer);
                closetimer = null;
            }
        }
        document.onclick = dd_close;

        $('#main-menu > li').bind('mouseover', dd_open);
        $('#main-menu > li').bind('mouseout',  dd_timer);

        $('#larr, #rarr').hide();
        $('.slideshow').hover(
            function(){
                $('#larr, #rarr').show();
            }, function(){
                $('#larr, #rarr').hide();
            }
        );

        /*** View mode ***/

        if ( $.cookie('mode') == 'grid' ) {
            grid_update();
        } else if ( $.cookie('mode') == 'list' ) {
            list_update();
        }

        $('#mode').toggle(
            function(){
                if ( $.cookie('mode') == 'grid' ) {
                    $.cookie('mode','list');
                    list();
                } else {
                    $.cookie('mode','grid');
                    grid();
                }
            },
            function(){
                if ( $.cookie('mode') == 'list') {
                    $.cookie('mode','grid');
                    grid();
                } else {
                    $.cookie('mode','list');
                    list();
                }
            }
        );

        function grid(){
            $('#mode').addClass('flip');
            $('#loop')
                .fadeOut('fast', function(){
                    grid_update();
                    $(this).fadeIn('fast');
                })
            ;
        }

        function list(){
            $('#mode').removeClass('flip');
            $('#loop')
                .fadeOut('fast', function(){
                    list_update();
                    $(this).fadeIn('fast');
                })
            ;
        }

        function grid_update(){
            $('#loop').addClass('grid').removeClass('list');
            $('#loop').find('.thumb img').attr({'width': '190', 'height': '190'});
            $('#loop').find('.post')
                .mouseenter(function(){
                    $(this)
                        .css('background-color','#FFEA97')
                        .find('.thumb').hide()
                        .css('z-index','-1');
                })
                .mouseleave(function(){
                    $(this)
                        .css('background-color','#f5f5f5')
                        .find('.thumb').show()
                        .css('z-index','1');
                });
            $('#loop').find('.post').click(function(){
                location.href=$(this).find('h2 a').attr('href');
            });
            $.cookie('mode','grid');
        }

        function list_update(){
            $('#loop').addClass('list').removeClass('grid');
            $('#loop').find('.post').removeAttr('style').unbind('mouseenter').unbind('mouseleave');
            $('#loop').find('.thumb img').attr({'width': '290', 'height': '290'});
            $.cookie('mode', 'list');
        }

        /*** Ajax-fetching posts ***/

        $('#pagination a').live('click', function(e){
            e.preventDefault();
            $(this).addClass('loading').text('Carregando...');
            $.ajax({
                type: "GET",
                url: $(this).attr('href') + '#loop',
                dataType: "html",
                success: function(out){
                    result = $(out).find('#loop .post');
                    nextlink = $(out).find('#pagination a').attr('href');
                    $('#loop').append(result.fadeIn(300));
                    $('#pagination a').removeClass('loading').text('Mostrar Mais');
                    if (nextlink != undefined) {
                        $('#pagination a').attr('href', nextlink);
                    } else {
                        $('#pagination').remove();
                    }
                    if ( $.cookie('mode') == 'grid' ) {
                        grid_update();
                    } else {
                        list_update();
                    }
                }
            });
        });

        /*** Misc ***/

        $('#comment, #author, #email, #url')
        .focusin(function(){
            $(this).parent().css('border-color','#888');
        })
        .focusout(function(){
            $(this).parent().removeAttr('style');
        });
        $('.rpthumb:last, .comment:last').css('border-bottom','none');

    })

$(document).ready(function () { 
   $('.navigation li').hover(
     function () {
     //show its submenu
       $('ul', this).stop().slideDown(100);
     }, 
     function () {
     //hide its submenu
       $('ul', this).stop().slideUp(100); 
     }
   );
 });
    
jQuery(document).ready(function ($) {
        //Ações dos icones 
        $('.masc').click(function () {
            $('#camp-fem').css('display','none');
            $('#camp-masc').fadeIn('slow');
        });
        $('.fem').click(function () {
            $('#camp-masc').css('display','none');
            $('#camp-fem').fadeIn('slow');
        });
});
})(jQuery)
