{extends file='parent:frontend/account/profile.tpl'}


{* Lastname *}
{block name="frontend_account_profile_profile_input_lastname"}
    {$smarty.block.parent}
    {if $invoiceEmail}
        <div class="profile--email profile-invoice-email">
            <input autocomplete="section-personal email invoice-email"                   
                   name="invoice_email"
                   type="email"
                   value="{$invoiceEmail}"
                   placeholder="{s name="invoiceEmail" namespace="frontend/register/index"}Ihre E-Mail-Adresse für die Rechnung{/s}"
                   class="profile--field profile--field-invoice-email {if $errorFlags.email}has--error{/if}" />
        </div>
    {/if}

{/block}



