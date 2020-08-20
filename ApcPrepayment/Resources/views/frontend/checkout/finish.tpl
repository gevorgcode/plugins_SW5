{extends file='parent:frontend/checkout/finish.tpl'}


{* Transaction number *}
{block name='frontend_checkout_finish_transaction_number'}
    {if $Locale == en_GB && $Payoner}       
        <div class="prepayment--details">
        IT-NERD24 GmbH <br>
        BIC: 231486 <br>
        Number : 06222297 <br>
        Name of the Bank: Barclays
        </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}
