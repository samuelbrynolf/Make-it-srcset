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
            var fragment = document.createDocumentFragment();
            var overlay = $('<div />', {
                click: function(){},
                id: settings.overlay_ID
            }).appendTo(fragment);

            // Create popup-clones
            popup_src.each(function(){
                var $this = $(this);
                var popped_id = $this.attr('data-misid');

                $this.clone()
                    .addClass(settings.imgcloned_class)
                    .attr('sizes', settings.pop_sizes)
                    .attr('id', popped_id).appendTo(fragment);
            });

            settings.body.append(fragment);
            var popup_elems = $('.' + settings.imgcloned_class).add(overlay);

            popup_src.on('click', function(e){
                var $this = $(this);

                overlay.addClass(settings.show_class);
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