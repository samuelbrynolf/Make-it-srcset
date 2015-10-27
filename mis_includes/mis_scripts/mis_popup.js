// Modal image, Version: 1.0
// ---------------------------------------------

(function($, document) {

    var popup_src = $('.mis_img'),
        body = $('body'),
        overlay_ID = 'mis_overlay',
        clones_exist = false,
        imgcloned_class = 'is-cloned',
        new_sizes_attr = '100vw',
        show_class = 's-is-visible';

    function create_popimg($this){
        var popped_img = $this;
        var popped_id = popped_img.attr('data-misid');

        popped_img.clone()
            .addClass(imgcloned_class)
            .attr('sizes', new_sizes_attr)
            .attr('id', popped_id).appendTo(body);
    }

    if(popup_src.length){
        // Create and append overlay
        var overlay = document.createElement('div');
        overlay.setAttribute('id', overlay_ID);
        document.body.appendChild(overlay);
        overlay = $('#'+overlay_ID); // Create jQuery object
    }

    popup_src.on('click', function(e){
        var $this = $(this);
        var popped_id = $this.attr('data-misid');

        if(!clones_exist){
            create_popimg($this);
        }

        overlay.addClass(show_class);
        $('#'+popped_id).addClass(show_class);

        e.preventDefault(e);
    });

    body.on('click', '#'+overlay_ID+', .'+imgcloned_class, function(e){

        if(!clones_exist){
            $('.'+imgcloned_class).remove();
            popup_src.each(function(){
                create_popimg($(this));
                clones_exist = true;
                clones = $('.'+imgcloned_class);
            });
        } else {
            clones.removeClass(show_class);
        }

        overlay.removeClass(show_class);

        e.stopPropagation();
        e.preventDefault();
    });

})(jQuery, document);