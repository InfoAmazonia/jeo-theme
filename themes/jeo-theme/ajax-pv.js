setTimeout(function(){
    (function($){
        $(function(){
            $.post(ajaxurl, {action: 'ajaxpv', ajaxpv: ajaxpv, ajaxpt: ajaxpt});
        });
    })(jQuery);
},2000)