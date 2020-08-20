;(function($, window, document) {

    $.plugin('apcAjaxSubmit', {

        init: function() {
            var me = this;

            me.applyDataAttributes();

            me.$listingContainer = $('.review--listing-container');
            
			me.registerEvents();
        },

        registerEvents: function(){
            var me = this;
            
            me._on(me.$el.find('a'), 'click', $.proxy(me.onLinkClick, me));
            console.log('event');
        },
        
		onLinkClick: function(e) {
			var me = this;

			e.preventDefault();
            
            var $target = $(e.currentTarget);
            
			me.callAjax($target.attr('href'), 'callbackLinkClick');
            
            $('html,body').animate({
                scrollTop: $('.tab--navigation').offset().top - 60
            }, 1000);
		},

		callbackLinkClick: function(response) {
			var me = this;
            
            me.$listingContainer.html(response.html);
            
            me.registerEvents();
		},
        
		callAjax: function(url, callback) {
			var me = this;

			$.ajax({
				type: "POST",
				url: url,
                data: {
                    isXHR: true,
                },
				success: function(response) {
					me[callback](response);
				}
			});
		},

    });

    window.StateManager.addPlugin('*[data-ajax-submit="true"]','apcAjaxSubmit');
    
})($, window, document);


