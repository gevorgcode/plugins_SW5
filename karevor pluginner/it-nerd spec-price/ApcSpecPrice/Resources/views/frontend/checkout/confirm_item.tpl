{extends file="parent:frontend/checkout/confirm_item.tpl"}

{block name="frontend_checkout_confirm_item_voucher_wrapper"}
    {if {$sBasketItem.ordernumber|truncate:4:""} == 'VnSp'}
                
    {else}
        {$smarty.block.parent}
    {/if}  
{/block}