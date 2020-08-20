{extends file="parent:frontend/checkout/change_shipping.tpl"}

{* Radio Button *}
{block name='frontend_checkout_dispatch_shipping_input_radio'}
    <div class="method--input input--checkbox-div">
        <input type="radio" id="confirm_dispatch{$dispatch.id}" class="radio auto_submit" value="{$dispatch.id}" name="sDispatch"{if $dispatch.id eq '11'} checked="checked"{/if} />
        <span class="input--state checkbox--state">&nbsp;</span> 
    </div>
{/block}
