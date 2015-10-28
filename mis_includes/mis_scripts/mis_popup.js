//// Modal image, Version: 1.0
//// ---------------------------------------------
//
//(function($, document) {
//
//    var popup_src = $('.mis_popup'),
//        body = $('body'),
//        overlay_ID = 'mis_overlay',
//        imgcloned_class = 'mis_is-cloned',
//        new_sizes_attr = '100vw',
//        show_class = 's-is-visible';
//
//    if(popup_src.length){
//        // Create and append overlay
//        var overlay = document.createElement('div');
//        overlay.setAttribute('id', overlay_ID);
//        document.body.appendChild(overlay);
//        overlay = $('#'+overlay_ID); // Create jQuery object
//
//        // Create popup-clones
//        popup_src.each(function(){
//            var $this = $(this);
//            var popped_id = $this.attr('data-misid');
//
//            $this.clone()
//                .addClass(imgcloned_class)
//                .attr('sizes', new_sizes_attr)
//                .attr('id', popped_id).appendTo(body);
//        });
//        var popup_elems = $('.'+imgcloned_class).add(overlay);
//    }
//
//    popup_src.on('click', function(e){
//        var $this = $(this);
//
//        overlay.addClass(show_class);
//        $('#'+ $this.attr('data-misid')).addClass(show_class);
//        e.stopPropagation();
//        e.preventDefault(e);
//    });
//
//    popup_elems.on('click', function(e){
//        popup_elems.removeClass(show_class);
//        e.preventDefault();
//    });
//
//})(jQuery, document);







(function( $, document ) {
    $.fn.mis_popup = function(options) {
        var settings = $.extend({
            body : $('body'),
            overlay_ID : 'mis_overlay',
            imgcloned_class : 'mis_is-cloned',
            show_class : 's-is-visible',
            pop_sizes : '100vw'
        }, options );

        var popup_src = this;

        if(popup_src.length){
            // Create and append overlay
            var overlay = document.createElement('div');
            overlay.setAttribute('id', settings.overlay_ID);
            document.body.appendChild(overlay); // append later?
            overlay = $('#'+settings.overlay_ID); // Create jQuery object

            // Create popup-clones
            popup_src.each(function(){
                var $this = $(this);
                var popped_id = $this.attr('data-misid');

                $this.clone()
                    .addClass(settings.imgcloned_class)
                    .attr('sizes', settings.pop_sizes)
                    .attr('id', popped_id).appendTo(settings.body);
            });

            var popup_elems = $('.'+settings.imgcloned_class).add(overlay);

            popup_src.on('click', function(e){
                var $this = $(this);

                overlay.addClass(settings.show_class); // add below?
                $('#'+ $this.attr('data-misid')).addClass(settings.show_class);
                
                e.stopPropagation();
                e.preventDefault(e);
            });

            popup_elems.on('click', function(e){
                popup_elems.removeClass(settings.show_class);
                e.preventDefault();
            });

            return this;
        }
    };
}( jQuery, document ));


(function($, document) {
    if($.fn.mis_popup) {
        var popup_src = $('.mis_popup');
        popup_src.mis_popup();
    }

})(jQuery, document);