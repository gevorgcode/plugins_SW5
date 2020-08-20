;(function ($,window,document) {

    var checkoutModal = {


        serialKeyModal: '.apc--checkout-finish-licens-modal',

        init: function() {
            var me = this;
            if($(me.serialKeyModal).length > 0){
                setTimeout( function() {
                      $.modal.open($(me.serialKeyModal).html(), {
                          animationSpeed: 350,
                          sizing: 'content',
                    });
                }, 3000);
            }

        },

    }

    var orderModal = {

        licenseButton: '.apc--view-license',
        serialKeyModal: '.apc--checkout-finish-licens-modal',
        serialHtml: '<p class="download--serial"><span class="is--strong">serilaHere</span></p>',
        init: function() {
            var me = this;
            $(me.licenseButton).click(function(){
                var html = $(me.serialKeyModal).html();
                var license = $(this).data('serials');
                var licenses = license.split(',');
                var final = '';
                licenses.forEach(function (license){
                    final += (me.serialHtml).replace("serilaHere", license);
                })
                html = html.replace('<p>serialhere</p>', final);
                $.modal.open(html, {
                    animationSpeed: 350,
                    sizing: 'content',
              });
            });
        }
    }

     $(document).ready(function(){
        var body = $('body');

        if (body.hasClass('is--act-finish')) {
            checkoutModal.init();
        }

        if (body.hasClass('is--act-orders')) {
            orderModal.init();
        }

    });




})($,window,document);
