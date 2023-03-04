$(function () {
    $('#logout').on('click',function (e) {
        e.preventDefault();
        $('.logout-form').submit();
    })

    $('.navbar-toggle').on('click',function(){
        if($(this).hasClass('show_menu')){
            $(this).removeClass('show_menu');
            $(this).addClass('collapsed');
            $('#slidemenu').removeClass('menu_mobile');
            $('.navbar-header').css('transform','none');
            $('main#page-content').css('transform','none');

        }else{
            $(this).removeClass('collapsed');
            $(this).addClass('show_menu');
            $('#slidemenu').addClass('menu_mobile');
            $('.navbar-header').css('transform','translateX(-245px)');
            $('main#page-content').css('transform','translateX(-245px)');
        }
    })

})
