{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'} 
    {block name='payment_ameria'}
        <div class="ameria-credit-agricole-bank-cc">            
             <div class="alert is--error is--rounded"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--cross"></i> 
                 </div>
                 <div class="alert--content"> 
                     {$response.errorMessage}
                 </div> 
            </div>            
        </div>        
    {/block}
{/block}