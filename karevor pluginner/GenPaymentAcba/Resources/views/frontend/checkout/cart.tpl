{extends file="parent:frontend/checkout/cart.tpl"}

{* Main content *}
{block name="frontend_index_content"}
    <div class="basket--info-messages">
        <div class="alert is--error is--rounded"> 
            <div class="alert--icon"> 
                <i class="icon--element icon--cross"></i> 
            </div>
            <div class="alert--content">
                {if $responseFromPay}{$responseFromPay.errorMessage}{/if}
                {if $AcbaPayParams}{$AcbaPayParams.actionCodeDescription}{/if}         
            </div> 
        </div>   
    </div> 
{$smarty.block.parent}
{/block}