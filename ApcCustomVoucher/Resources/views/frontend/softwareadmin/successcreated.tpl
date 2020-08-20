{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}    
    <div class="container" style="padding: 50px 0">
       <div class="alert is--success is--rounded"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--check"></i> 
             </div>
             <div class="alert--content"> 
                 Account created successfully.
             </div> 
        </div>
        <div class="alert is--warning is--rounded" style="margin-top: 25px;"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--warning"></i>
             </div>
             <div class="alert--content"> 
                 You need to copy this login and password. After exiting this page it will not be possible to see the password.
             </div> 
        </div>
        <p style="padding-top: 30px; margin: 0;">Login: <strong>{$creator.creatorLogin}</strong></p>
        <p>Pasword: <strong>{$creator.creatorPass}</strong></p>        
        <a href="/softwareadmin/index">Back</a>
    </div>
{/block}