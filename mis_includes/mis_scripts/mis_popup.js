// Modal image, Version: 1.0
// ---------------------------------------------

(function($, document) {

    var popup_src = $('.mis_popup'),
        body = $('body'),
        overlay_ID = 'mis_overlay',
        imgcloned_class = 'is-cloned',
        new_sizes_attr = '100vw',
        show_class = 's-is-visible';

    if(popup_src.length){
        // Create and append overlay
        var overlay = document.createElement('div');
        overlay.setAttribute('id', overlay_ID);
        document.body.appendChild(overlay);
        overlay = $('#'+overlay_ID); // Create jQuery object

        // Create popup-clones
        popup_src.each(function(){
            var popped_img = $(this);
            var popped_id = popped_img.attr('data-misid');

            popped_img.clone()
                .addClass(imgcloned_class)
                .attr('sizes', new_sizes_attr)
                .attr('id', popped_id).appendTo(body);
        });
        var clones = $('.'+imgcloned_class);
    }

    popup_src.on('click', function(e){
        var $this = $(this);
        var popped_img = $('#'+ $this.attr('data-misid'));

        overlay.addClass(show_class);
        popped_img.addClass(show_class);

        e.preventDefault(e);
    });

    //body.on('click', '#'+overlay_ID+', .'+imgcloned_class, function(e){
    overlay.add(clones).on('click', function(e){
        clones.removeClass(show_class);
        overlay.removeClass(show_class);

        e.stopPropagation();
        e.preventDefault();
    });

})(jQuery, document);