$(document).ready(function () {
    $(document).on('click', 'body .menu', function () {
        $('.fullMenu').fadeIn();
        return false;
    });
    $(document).on('click', 'body .fullMenu', function () {
        $('.fullMenu').fadeOut();
    });
    $('#citySelect,#citySelect2').change(function () {
        $(this).parents('form').attr('action', $(this).val());
        $(this).parents('form').submit();
    });
    $(".scrolled").click(function () {
        var elementClick = $(this).attr("href");
        var destination = $(elementClick).offset().top;
        $('html,body').animate({scrollTop: destination}, 1100);
        return false;
    });
    $('.menu-button').click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('active') === true) {
            $(this).removeClass('active');
            $('.left-fixed-gleb').removeClass('active');
            $('.fon-menu-gleb').removeClass('active');
        } else {
            $(this).addClass('active');
            $('.left-fixed-gleb').addClass('active');
            $('.fon-menu-gleb').addClass('active');
        }
    });
    $('.child-gleb').click(function () {
        $(this).parent('li').children('ul').slideToggle();
    });
    var height = $(window).height() - 40;
    $('.scroll-gleb').height(height);
});
$(window).scroll(function () {
    if ($(this).scrollTop() > 130) {
        $('header').addClass('prozr');
    } else {
        $('header').removeClass('prozr');
    }

});
//begin всплывающий баннер
var delay_popup = 2000;
var msg_pop = document.getElementById('msg_pop');
setTimeout("document.getElementById('msg_pop').style.display='block';document.getElementById('msg_pop').className += 'fadeIn';", delay_popup);
//end всплывающий баннер