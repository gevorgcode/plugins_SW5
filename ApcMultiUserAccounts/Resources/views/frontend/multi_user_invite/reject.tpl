{extends file='parent:frontend/account/index.tpl'}

{namespace name="frontend/account/multiuser"}

{* Main content *}
{block name="frontend_index_content"}
    <div class="multiuser--invite--message">
        <div class="multiuser--accounts--email--error alert is--success is--rounded"> 
            <div class="alert--icon"> 
                <i class="icon--element icon--check"></i> 
            </div>
            <div class="alert--content"> 
                Sie haben die Einladung erfolgreich abgelehnt. Ihr Konto wurde nicht aktiviert.
            </div> 
        </div>      
    </div>      
{/block}