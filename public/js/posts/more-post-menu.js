$(document).ready(function() {
    $('.post-menu-more-btn').click(function(){
        var id = $(this).data('id');
        $('.post-'+id ).toggle();
    });
});