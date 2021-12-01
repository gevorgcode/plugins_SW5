;(function($, window, document) {

    var xmasCopyCode = {        

       copyButton: "#xmas21--copy",
       codeSelector: "#xmas21--code",
       copiedSelector: "#xmas21--copy-copied",

        init: function(){
            var me = this;
            me.copyCode();            
        },

        copyCode: function(){
            var me = this;
            $(me.copyButton).click(function(){
                var text = $(this).attr('data-copy');
                var request = me.copyToClipboard(text);
                if(request){
                    me.showCopied();
                }                
            });
        },

        showCopied: function(){            
            var me = this;
            $(me.codeSelector).animate({opacity: 0}, 300);
            $(me.copiedSelector).animate({opacity: 1}, 300);
            setTimeout(function(){
                $(me.codeSelector).animate({opacity: 1}, 500);
                $(me.copiedSelector).animate({opacity: 0}, 500);
            }, 800);                      
        },       

        copyToClipboard: function(text) {
            var textArea = document.createElement( "textarea" );
            textArea.value = text;
            document.body.appendChild( textArea );
   
            textArea.select();
   
            try {
               var successful = document.execCommand( 'copy' );
            } catch (err) {
               successful = false;
            }
   
            document.body.removeChild( textArea );
            return successful;
         },
    };    

    $(document).ready(function() {
        xmasCopyCode.init();        
    });    

})(jQuery, window, document);
