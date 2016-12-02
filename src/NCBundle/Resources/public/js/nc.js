jQuery(function($) {
    $(document).ready( function() {
        $('.templatemo-gallery-category a').click(function(e){
            e.preventDefault();
            $(this).parent().children('a').removeClass('active');
            $(this).addClass('active');
            var linkClass = $(this).attr('href');
            $('.gallery').each(function(){
                if($(this).is(":visible") == true){
                    $(this).hide();
                };
            });
            $(linkClass).fadeIn();
        });
    });
});
