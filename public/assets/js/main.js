function stickyHeader() {
    if ($(window).scrollTop() > 10) {
        $('header').addClass('fixed');
    }
    else {
        $('header').removeClass('fixed');
    }
}
$(window).bind("load scroll", function () {
    stickyHeader();
});
$(window).bind('resize load', function () {
    $('.categories-content').slimScroll({
        height: $('.sidebar-categories').height() - $('.sidebar-header').height() + -20
    });
    $('.menu-content').slimScroll({
        height: $('.mobile-menu').height() - $('.sidebar-menu-header').height() + -20
    });
    if ($(window).width() > 991) {
        $('body').removeClass('overflow-hidden');
    }
})
$(document).ready(function () {
    $('.mbl-menu-btn').click(function(){
        $('.sidebar-menu').addClass('active');
        $('.sidebar-backdrop').addClass('active');
    });
    $('.sidebar-close').click(function(){
        $('.sidebar-menu').removeClass('active');
        $('.sidebar-backdrop').removeClass('active');
    });

    var swiper = new Swiper("#bannerSlider", {
        spaceBetween: 0,
        effect: "fade",
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
});