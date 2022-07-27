{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_content'}    
    <div class="alert is--success is--rounded" style="margin-top: 100px"> 
        <div class="alert--icon"> 
        <i class="icon--element icon--check"></i> 
        </div>
        <div class="alert--content"> 
            {s name="unsubg"}Sie wurden erfolgreich abgemeldet!{/s}
        </div> 
    </div>
{/block}