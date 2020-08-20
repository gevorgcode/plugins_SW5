{extends file='parent:frontend/register/login.tpl'}


{block name='frontend_register_login_input_form_submit'}
    {if $productKey}
        <input type="hidden" name="soft_order_serial_id" value="{$serialId}">
    {/if}    
    {$smarty.block.parent}
{/block}