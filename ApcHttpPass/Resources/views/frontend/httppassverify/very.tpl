{extends file='parent:frontend/index/index.tpl'}

{* Sidebar left *}
{block name='frontend_index_content_left'}{/block}



{block name="frontend_index_page_wrap"}
    <div class="error" style="width: 600px; margin: 0 auto; margin-top: 50px;">
        <div class="alert is--error is--rounded"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--cross"></i> 
             </div>
             <div class="alert--content"> 
                 Wrong Password
             </div> 
        </div>
        <a class="btn is--primary" href="{url controller=Httppassverify action=index}" style="border-color: red; margin-top: 50px; width: 100%; text-align: center">back</a>
    </div>
{/block}
