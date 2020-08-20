{extends file='parent:frontend/forms/form-elements.tpl'}

{namespace name="frontend/forms/elements"}

{* Forms actions *}
{block name='frontend_forms_form_elements_form_submit'}
    <div class="buttons">
        <button class="btn is--primary is--icon-right" type="submit" name="Submit" value="submit">
            {if {$id} == '23'}
                {s name='SupportActionSubmitGesch'}Anfrage verzenden{/s}
            {else}
                {s name='SupportActionSubmit'}{/s}<i class="icon--arrow-right"></i>
            {/if}
        </button>
    </div>
{/block}
