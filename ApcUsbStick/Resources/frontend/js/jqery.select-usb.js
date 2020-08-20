;(function($, window, document) {

    $(document).ready(function() {
        var optionval = $('[name="group[10]"]').children("option:selected").val();
        if (optionval != 15){
            $('.usb--stick-logo-cont .usb--stick-usb.usb-l').addClass('is--hidden');
        }
        
        $('body').on("change", '[name="group[10]"]', function(){
            var optionval = $('[name="group[10]"]').children("option:selected").val();
            
            setTimeout(function(){ 
                if (optionval == 15){
                $('.usb--stick-logo-cont .usb--stick-usb.usb-l').removeClass('is--hidden');
                }else{
                    $('.usb--stick-logo-cont .usb--stick-usb.usb-l').addClass('is--hidden');
                }           
            }, 1000);   
            
        });
    });    
    
    
})(jQuery, window, document);

