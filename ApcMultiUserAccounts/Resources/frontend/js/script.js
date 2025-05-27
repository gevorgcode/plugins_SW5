;(function($, window, document) {

    $(document).ready(function() {
        $(document).ready(function () {
            var target = $('#multiuser--message--top');
            if (target.length) {
                $('html, body').animate({
                    scrollTop: target.offset().top - 20
                }, 500); 
            }
        });
    });
})(jQuery, window, document);    