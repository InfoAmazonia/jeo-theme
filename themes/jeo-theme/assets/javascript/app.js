import Vue from 'vue';
import ImageBlock from './components/imageBlock/ImageBlock';

Vue.component('image-block', ImageBlock);



(function ($) {
    $(document).ready(function () {
        const app = new Vue({
            el: '#content',
        })

        if($('.single .featured-image-behind').length) {
            $('.featured-image-behind .image-info i').click(function() {
                $('.featured-image-behind .image-info-container').toggleClass('active');
                $('.featured-image-behind .image-info i').toggleClass('fa-info-circle fa-times-circle ');
            });
        }

        // $(window).scroll(function () {
        //     var headerHeight = $('.middle-header-contain').height();
        //     // console.log(headerHeight);
        //     if ($(this).scrollTop() > headerHeight) {
        //         $('.bottom-header-contain').addClass("fixed-header");
        //     } else {
        //         $('.bottom-header-contain').removeClass("fixed-header");
        //     }
        // });

        jQuery('.filters select').change(function() {
            jQuery(this).closest('form').submit();
        });

        jQuery('input[name="daterange"]').daterangepicker({
            'minDate': '01/01/2010',
            'maxDate': new Date(),
            'autoUpdateInput': false,
            'locale': {
                cancelLabel: 'Clear'
            }
        });

        jQuery('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        jQuery('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        if(jQuery('input[name="daterange"]').attr('replace-empty') === "true") {
            jQuery('input[name="daterange"]').val('')
        }

        if(jQuery('.sorting-method').length) {
            jQuery('.sorting-method .current').click(function() {
                jQuery('.sorting-method .options').toggleClass('active');
                jQuery('#sorting').attr('value', jQuery('.sorting-method .options button').attr('value'));
            });

            jQuery('.sorting-option').click(function() {
                jQuery('#sorting').attr('value', jQuery(this).attr('value'));
                jQuery(this).closest('form').submit();
            });


        }
    });
})(jQuery);
