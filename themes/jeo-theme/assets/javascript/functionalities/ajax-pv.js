setTimeout(function(){
    (function($){
        $(function(){
            if(document.querySelector('.single')) {
                $.post(ajaxurl, {action: 'ajaxpv', ajaxpv: ajaxpv, ajaxpt: ajaxpt});
            }
        });
    })(jQuery);
},2000)