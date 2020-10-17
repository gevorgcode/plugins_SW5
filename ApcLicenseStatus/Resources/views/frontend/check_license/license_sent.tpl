{extends file='parent:frontend/index/index.tpl'}

{namespace name="ApcLicenseStatus"}

{block name='frontend_index_content_main'}
    <section class="{block name="frontend_index_content_main_classes"}content-main container block-group{/block}">       
        <div class="alert is--success is--rounded"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--check"></i> 
             </div>
             <div class="alert--content"> 
                 License sent successfully.
             </div> 
        </div>   
        {*}<a class="is--hidden" id="back-return" href="{$returnUrl}">Back</a>{*}
        <script type='text/javascript'> 
            setTimeout(function() {  
                window.close();                
            }, 1500)
         </script>
    </section>
{/block}
