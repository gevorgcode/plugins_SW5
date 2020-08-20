{extends file='parent:frontend/index/index.tpl'}

{* Sidebar left *}
{block name='frontend_index_content_left'}{/block}


{block name='frontend_index_content'}  
    <div class="software--code-error">
        <div class="alert is--error is--rounded"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--cross"></i> 
             </div>
             <div class="alert--content"> 
                 {s name='SupportActionSubmit' namespace='frontend/softwareCode'}Ungültiger Software-Code{/s}
             </div> 
        </div>
    </div>
{/block}