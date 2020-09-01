{extends file="parent:frontend/checkout/cart_item.tpl"}


{block name="frontend_checkout_cart_item_voucher_wrapper"}
    {if {$sBasketItem.ordernumber|truncate:4:""} == 'VnSp'}
                
    {else}
        {$smarty.block.parent}
    {/if}    
{/block}