;(function($, window, document) {

    var ehiNote = {        
        
        ehiSelector: ".ehi--close",
        ehiContainerSelector: ".ehi--note-cont",
        
        init: function(){
            var me = this;
            me.closeEhi();
        },
        
        closeEhi: function(){
            var me = this;
            $(me.ehiSelector).on("click", function(){
                $(me.ehiContainerSelector).addClass('is--hidden');
                var url = $(me.ehiContainerSelector).attr('data-ajaxurl');
                $.ajax({
                    url: url, 
                    data: {"EhiTopCookie":"Yes"},
                    success: function(result){
                }});
            });
        },        
    };
    
    $(document).ready(function() {
            ehiNote.init(); 
    });
    
})(jQuery, window, document);