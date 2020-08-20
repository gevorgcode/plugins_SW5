{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}    
    <div class="container" style="padding: 50px 0">
        <div class="alert is--error is--rounded" style="margin-bottom: 50px;"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--cross"></i> 
             </div>
             <div class="alert--content"> 
                 This login <span style="color: black;">"{$creator}"</span> is already registered.
             </div> 
        </div>
        
        <a href="/softwareadmin/index">Back</a>
    </div>
{/block}
