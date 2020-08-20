{extends file='parent:frontend/checkout/change_payment.tpl'}


{block name='frontend_checkout_payment_content'}
    <div class="panel--body is--wide block-group">
        {foreach $sPayments as $payment_mean}
            {if {$payment_mean.id == '77'} && {!$SepaPay}}
                    {continue}
                {/if} 
            <div class="payment--method block{if $payment_mean@last} method_last{else} method{/if}">

                {* Radio Button *}
                {block name='frontend_checkout_payment_fieldset_input_radio'}
                    <div class="method--input">
                        <input type="radio" name="payment" class="radio auto_submit" value="{$payment_mean.id}" id="payment_mean{$payment_mean.id}"{if $payment_mean.id eq $sFormData.payment or (!$sFormData && !$smarty.foreach.register_payment_mean.index)} checked="checked"{/if} />
                    </div>
                {/block}

                {* Method Name *}
                {block name='frontend_checkout_payment_fieldset_input_label'}
                    <div class="method--label is--first">
                        <label class="method--name is--strong" for="payment_mean{$payment_mean.id}">{$payment_mean.description}</label>
                    </div>
                {/block}

                {* Method Description *}
                {block name='frontend_checkout_payment_fieldset_description'}
                    <div class="method--description is--last">
                        {include file="string:{$payment_mean.additionaldescription}"}
                    </div>
                {/block}

                {* Method Logo *}
                {block name='frontend_checkout_payment_fieldset_template'}
                    <div class="payment--method-logo payment_logo_{$payment_mean.name}"></div>
                    {if "frontend/plugins/payment/`$payment_mean.template`"|template_exists}
                        <div class="method--bankdata{if $payment_mean.id != $form_data.payment} is--hidden{/if}">
                            {include file="frontend/plugins/payment/`$payment_mean.template`" form_data=$sFormData error_flags=$sErrorFlag payment_means=$sPayments}
                        </div>
                    {/if}
                {/block}
            </div>
        {/foreach}
         {if {$trsh}}
        <div class="payment--method block method"> <div class="method--input"> <input disabled type="radio" name="payment" class="radio auto_submit" value="76" id="payment_mean"> </div> <div class="method--label is--first"> <label class="method--name is--strong" for="payment_mean76">PayPal</label> </div> <div class="method--description is--last"> Sie werden auf die abgesicherte PayPal Seite weitergeleitet, um die Zahlung abzuschließen.<br>Unsere Zahlungen werden von unserem Zahlungsanbieter Novalnet durchgeführt. </div> <div class="payment--method-logo payment_logo_novalnetpaypal"></div> <div class="method--bankdata"> <br> <div> <a href="https://www.novalnet.de" title="" target="_blank" style="text-decoration:none;" rel="nofollow noopener"> <img src="/engine/Shopware/Plugins/Community/Frontend/NovalPayment/Views/frontend/_resources/images/novalnetpaypal.png" alt="PayPal" title="PayPal" style="border:none;display: inline-block;"> </a> </div> <div class="space"></div> <div class="debit"> <input type="hidden" name="novalnetpaypalShopVersion" id="novalnetpaypalShopVersion" value="5.5.6"> <noscript> <span style="color:red">Aktivieren Sie bitte JavaScript in Ihrem Browser, um die Zahlung fortzusetzen. </span> </noscript> <div id="novalnetpaypal_ref_details" style="display:none"> <p class="none"> <label style="width:50%;">Novalnet Transaktions-ID</label> <br><input type="text" style="width:70%;" value="" readonly=""> </p> </div> <input type="hidden" id="novalnetpaypal_given_account" name="novalnetpaypal_given_account" value="Angegebene PayPal-Kontodetails"> <input type="hidden" id="novalnetpaypal_new_account" name="novalnetpaypal_new_account" value="Mit neuen PayPal-Kontodetails fortfahren"> <input type="hidden" id="nn_paypal_new_acc_details" name="nn_paypal_new_acc_details" value="1"> <input type="hidden" id="nn_paypal_new_acc_form" name="nn_paypal_new_acc_form" value="1"> <input type="hidden" id="nn_paypal_paymentid" name="nn_paypal_paymentid" value="76"> <input type="hidden" id="paypalref_lang_before" value="Nach der erfolgreichen Überprüfung werden Sie auf die abgesicherte Novalnet-Bestellseite umgeleitet, um die Zahlung fortzusetzen.<br>Bitte schließen Sie den Browser nach der erfolgreichen Zahlung nicht, bis Sie zum Shop zurückgeleitet wurden.">  </div> </div> </div>
        {/if}
    </div>
{/block}