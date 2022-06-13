$(document).ready(function(){

    $('*[data-sidebar=nav-menu]').click(function(){
        $('.mobile-menu').toggleClass('active');
        $('body').toggleClass('overflow-hidden');
    })
    $('.more_btn').click(function(){
        event.preventDefault();
        $('.more_data_content').toggleClass('fullshow');
        $('.more_container').toggleClass('text-center')
    })
});