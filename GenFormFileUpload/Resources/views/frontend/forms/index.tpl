{extends file='parent:frontend/forms/index.tpl'}
{namespace name='frontend/gen_form_file_upload/main'}

{block name='frontend_forms_elements_error'}
    {if $sSupport.sErrors.v}
        {foreach from=$sSupport.sErrors.v key=sKey item=sError}
            {if $sSupport.sElements[$sError].typ eq 'file' || $sSupport.sElements[$sError].typ eq 'files' && !$sSupport.sElements[$sError].error_msg}
                {$sSupport.sElements[$sError].error_msg = "{s name='FileNotValid'}{/s}"}
            {/if}
        {/foreach}
    {/if}
    {$smarty.block.parent}
{/block}
