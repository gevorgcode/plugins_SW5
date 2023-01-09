{extends file='parent:frontend/register/billing_fieldset.tpl'}


 {* VAT Id *}
{block name='frontend_register_billing_fieldset_input_vatId'}
   {$smarty.block.parent}
    
    <div class="register--email register--invoice--email">
        <input autocomplete="section-personal email"
               name="register[invoice][email]"
               type="email"               
               placeholder="{s name="invoiceEmail" namespace="frontend/register/index"}Ihre E-Mail-Adresse für die Rechnung{/s}"
               id="register_invoice_email"
               value="{$form_data.invoice_email|escape}"
               class="register--field invoice--email email {if isset($error_flags.email)} has--error{/if}" />
    </div>
{/block}

 