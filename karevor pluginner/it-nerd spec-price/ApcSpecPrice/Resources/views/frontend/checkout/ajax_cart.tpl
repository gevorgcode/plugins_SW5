{extends file="parent:frontend/checkout/ajax_cart.tpl"}




{block name='frontend_checkout_ajax_cart_item_container_inner'}
    {if $sBasket.content}
        {foreach $sBasket.content as $sBasketItem}
            {block name='frontend_checkout_ajax_cart_row'}            
                {if {$sBasketItem.ordernumber|truncate:4:""} == 'VnSp'}
                    
                {else}
                    {include file="frontend/checkout/ajax_cart_item.tpl" basketItem=$sBasketItem}
                {/if}
            {/block}
        {/foreach}
    {else}
        {block name='frontend_checkout_ajax_cart_empty'}
            <div class="cart--item is--empty">
                {block name='frontend_checkout_ajax_cart_empty_inner'}
                    <span class="cart--empty-text">{s name='AjaxCartInfoEmpty'}{/s}</span>
                {/block}
            </div>
        {/block}
    {/if}
{/block}
           

