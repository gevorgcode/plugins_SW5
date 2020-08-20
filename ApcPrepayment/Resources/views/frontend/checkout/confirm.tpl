{extends file="parent:frontend/checkout/confirm.tpl"}


{* Additional customer comment for the order *}
{block name='frontend_checkout_confirm_comment'}  
    {if $Payoner && $sComment}
        <div class="feature--user-comment block is--hidden">
            <p>{s name="confirmUserComment" namespace="frontend/checkout/confrm"}Wenn Sie uns eine Nachricht zu Ihrer Bestellung hinterlassen möchten, tragen Sie sie bitte hier ein.{/s}</p>
            <textarea class="user-comment--field" data-storage-field="true" data-storageKeyName="sComment" rows="5" cols="20" data-pseudo-text="true" data-selector=".user-comment--hidden">'IT-NERD24 GmbH 
                  BIC: 231486 
                  Number : 06222297 
                  Name of the Bank: Barclays'</textarea>
        </div>
        <div class="feature--user-comment block">
            <p>{s name="confirmUserComment" namespace="frontend/checkout/confrm"}Wenn Sie uns eine Nachricht zu Ihrer Bestellung hinterlassen möchten, tragen Sie sie bitte hier ein.{/s}</p>
            <textarea class="user-comment--field"></textarea>
        </div>
    {else}
        <div class="feature--user-comment block">
            <p>{s name="confirmUserComment" namespace="frontend/checkout/confrm"}Wenn Sie uns eine Nachricht zu Ihrer Bestellung hinterlassen möchten, tragen Sie sie bitte hier ein.{/s}</p>
            <textarea class="user-comment--field" data-storage-field="true" data-storageKeyName="sComment" rows="5" cols="20" data-pseudo-text="true" data-selector=".user-comment--hidden">{$sComment|escape}</textarea>
        </div>
    {/if}
{/block}
