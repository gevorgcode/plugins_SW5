;(function ($,window,document) {

   
     $(document).ready(function(){        
        if ($('body').hasClass('is--ctl-softwarecode') || $('body').hasClass('is--act-finish')) {
            $(".sd--btn-download").click(function(){
                $('.software--download-links').slideToggle();
            });            
        }
         
         if ($('body').hasClass('is--ctl-account')) {
            $(".sd--code--down--js").click(function(){
                if ($(this).hasClass('is--opened')){
                    $(this).addClass('is--closed').removeClass('is--opened');
                }else{
                    $(this).addClass('is--opened').removeClass('is--closed');
                }
                $('.is--opened .account--softcode-download-links').slideDown();
                $('.is--closed .account--softcode-download-links').slideUp();
            });            
        }
         
    });
    
    
    
    
    
    
    

})($,window,document);
