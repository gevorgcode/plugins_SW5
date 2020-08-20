{extends file="parent:frontend/account/order_item_details.tpl"}

{block name="frontend_account_order_item_repeat_button"}
    {$smarty.block.parent}
    {if {config name="showInOrderHistory" namespace="genSendInvoices"} && $offerPosition.invoice }
    <input type="button" class="btn is--small" onClick="javascript:location.href='{url controller="invoice" id=$offerPosition.invoice }'" value="{s name="invoice_button" namespace="account/gen_account_invoice"}{/s}" />
    {/if}
{/block}


