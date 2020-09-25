{extends file='parent:frontend/forms/form-elements.tpl'}

{block name='frontend_forms_form_elements_form_content'}
    {* ensure that `files` input type is rendered in block 'frontend_forms_form_elements_form_builder' *}
    {foreach $sSupport.sElements as $sKey => $sElement}
        {if $sElement.typ == 'files'}
            {$sSupport.sFields[$sKey] = true}
        {/if}
    {/foreach}
    {$smarty.block.parent}
{/block}

{block name='frontend_forms_form_elements_form_builder'}
    <div {if $sSupport.sElements[$sKey].typ eq 'textarea'}class="textarea"
         {elseif $sSupport.sElements[$sKey].typ eq 'checkbox'}class="forms--checkbox"
         {elseif $sSupport.sElements[$sKey].typ eq 'select'}class="field--select select-field"{/if}>
        {if $sSupport.sElements[$sKey].typ eq 'file' || $sSupport.sElements[$sKey].typ eq 'files'}
            <label for="{$sSupport.sElements[$sKey].name}"
                   class="{$sSupport.sElements[$sKey].class}">{$sSupport.sElements[$sKey].label}{if $sSupport.sElements[$sKey].required}{s name='RequiredField' namespace='frontend/register/index'}{/s}{/if}</label>
            <input type="file" name="{if $sSupport.sElements[$sKey].typ eq 'files'}{$sSupport.sElements[$sKey].name}[]{else}{$sSupport.sElements[$sKey].name}{/if}" id="{$sSupport.sElements[$sKey].name}"
                   class="{$sSupport.sElements[$sKey].class}"{if $sSupport.sElements[$sKey].required} required="required" aria-required="true"{/if}
                   accept=".{if $sSupport.sElements[$sKey].value}{$sSupport.sElements[$sKey].value|replace:";":", ."}{else}{{config name=allowedFileTypes}|replace:";":", ."}{/if}" {if $sSupport.sElements[$sKey].typ eq 'files'} multiple="multiple"{/if}/>
        {else}
            {$sSupport.sFields[$sKey]|replace:'%*%':"{s name='RequiredField' namespace='frontend/register/index'}{/s}"}
        {/if}

        {if $sSupport.sElements[$sKey].typ eq 'checkbox'}
            {$sSupport.sLabels.$sKey|replace:':':''}
        {/if}
    </div>
{/block}
