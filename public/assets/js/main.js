$(document).ready(function(){

    $('*[data-sidebar=nav-menu]').click(function(){
        $('.mobile-menu').toggleClass('active');
        $('body').toggleClass('overflow-hidden');
    })

});