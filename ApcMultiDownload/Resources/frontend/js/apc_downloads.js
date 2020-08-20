;(function ($,window,document) {

    var multiDownloads = {

        downlaodsButton: '.apc--download-btn',

        init: function() {
            var me = this;

            me.registerEvents();
        },

        registerEvents: function() {
            var me  = this;
            $(me.downlaodsButton).click(function() {

                var articleId = $(this).data('articleid');
                var esdLink = $(this).data('esdLink');
                var url = 'https://'+window.location.hostname+'/ApcDownload/modal/';

                // $.loadingIndicator.open();

                me.sendAjax(url,{
                    articleId: articleId,
                    esdLink: esdLink
                },'downloadsCallback');

            });

        },

        downloadsCallback: function(response) {
            var me = this;

            $.modal.open(response, {
                animationSpeed: 350,
                sizing: 'content',
                width: 520,
            });
            // $.loadingIndicator.close();

        },

        sendAjax: function(url,data,callback){
            var me = this;
            $.ajax({
                type: 'POST',
                data: data,
                url: url,
                success: function(response) {
                    me[callback](response);
                }
           });
       },

    };

    $(document).ready(function(){
        var body = $('body');
        if(body.hasClass('is--act-downloads') || body.hasClass('is--act-orders') || body.hasClass('is--ctl-account') && body.hasClass('is--act-index')) {
            multiDownloads.init();
        }
    });

})($,window,document);
