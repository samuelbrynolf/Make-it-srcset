// Modal image, Version: 1.0
// ---------------------------------------------

(function($, document) {

    var popup_trigger = $('.mis_container'),
        body = $('body'),
        items_cloned = false,
        new_sizes = '100vw',
        show_class = 's-is-visible',
        imgcloned_class = 'is-cloned',
        overlay_ID = 'mis_overlay';


    function create_popimg($this){
        var popped_img = $this.find('img');
        var popped_id = popped_img.attr('data-misid');

        popped_img.clone()
            .addClass(imgcloned_class)
            .attr('sizes', new_sizes)
            .attr('id', popped_id).appendTo(body);
    }

    if(popup_trigger.length){
        // Create and append overlay
        var overlay = document.createElement('div');
        overlay.setAttribute('id', overlay_ID);
        document.body.appendChild(overlay);
        overlay = $('#'+overlay_ID); // Create jQuery object
    }

    popup_trigger.on('click', function(e){
        var $this = $(this);

        overlay.addClass(show_class);

        if(!items_cloned){
            create_popimg($this);
        }

        e.preventDefault(e);
    });

    body.on('click', '#'+overlay_ID+', .'+imgcloned_class, function(e){

        if(!items_cloned){
            $('.'+imgcloned_class).remove();
            popup_trigger.each(function(){
                $this = $(this);
                create_popimg($this);
                items_cloned = true;
            });
        }

        overlay.removeClass(show_class);
        e.stopPropagation();
        e.preventDefault();
    });

})(jQuery, document);