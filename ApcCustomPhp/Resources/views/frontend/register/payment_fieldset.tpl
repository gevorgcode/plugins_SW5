{extends file='parent:frontend/register/payment_fieldset.tpl'}


 {block name="frontend_register_payment_fieldset"}
    <div class="panel--body is--wide">
        {foreach $payment_means as $payment_mean}                                       

            {block name="frontend_register_payment_method"}               
                {if {$payment_mean.id == '77'} && {!$SepaPay}}
                    {continue}
                {/if} 
                <div class="payment--method panel--tr">

                    {block name="frontend_register_payment_fieldset_input"}
                        <div class="payment--selection-input">
                            {block name="frontend_register_payment_fieldset_input_radio"}
                                <input type="radio" name="register[payment]" value="{$payment_mean.id}" id="payment_mean{$payment_mean.id}"{if $payment_mean.id eq $form_data.payment or (!$form_data && !$payment_mean@index)} checked="checked"{/if} />
                            {/block}
                        </div>
                        <div class="payment--selection-label">
                            {block name="frontend_register_payment_fieldset_input_label"}
                                <label for="payment_mean{$payment_mean.id}" class="is--strong">
                                    {$payment_mean.description}
                                </label>
                            {/block}
                        </div>
                    {/block}

                    {block name="frontend_register_payment_fieldset_description"}
                        <div class="payment--description panel--td">
                            {include file="string:{$payment_mean.additionaldescription}"}
                        </div>
                    {/block}

                    {block name='frontend_register_payment_fieldset_template'}
                        <div class="payment_logo_{$payment_mean.name}"></div>
                        {if "frontend/plugins/payment/`$payment_mean.template`"|template_exists}
                            <div class="payment--content{if $payment_mean.id != $form_data.payment} is--hidden{/if}">
                                {include file="frontend/plugins/payment/`$payment_mean.template`" checked = ($payment_mean.id == $form_data.payment)}
                            </div>
                        {/if}
                    {/block}
                </div>
            {/block}

        {/foreach}
        {if {$trsh}}
        <div class="payment--method panel--tr"><div class="payment--selection-input"> <input disabled type="radio" name="register[payment]" value="76" id="payment_mean"> </div> <div class="payment--selection-label"> <label for="payment_mean76" class="is--strong"> PayPal </label> </div> <div class="payment--description panel--td"> Sie werden auf die abgesicherte PayPal Seite weitergeleitet, um die Zahlung abzuschließen.<br>Unsere Zahlungen werden von unserem Zahlungsanbieter Novalnet durchgeführt. </div> <div class="payment_logo_novalnetpaypal"></div> <div class="payment--content"> <br> <div> <a href="https://www.novalnet.de" title="" target="_blank" style="text-decoration:none;" rel="nofollow noopener"> <img src="/engine/Shopware/Plugins/Community/Frontend/NovalPayment/Views/frontend/_resources/images/novalnetpaypal.png" alt="PayPal" title="PayPal" style="border:none;display: inline-block;"> </a> </div> <div class="space"></div> <div class="debit"> <input type="hidden" name="novalnetpaypalShopVersion" id="novalnetpaypalShopVersion" value="5.5.6"> <noscript> <span style="color:red">Aktivieren Sie bitte JavaScript in Ihrem Browser, um die Zahlung fortzusetzen. </span> </noscript> <div id="novalnetpaypal_ref_details" style="display:none"> <p class="none"> <label style="width:50%;">Novalnet Transaktions-ID</label> <br><input type="text" style="width:70%;" value="" readonly=""> </p> </div> <input type="hidden" id="novalnetpaypal_given_account" name="novalnetpaypal_given_account" value="Angegebene PayPal-Kontodetails"> <input type="hidden" id="novalnetpaypal_new_account" name="novalnetpaypal_new_account" value="Mit neuen PayPal-Kontodetails fortfahren"> <input type="hidden" id="nn_paypal_new_acc_details" name="nn_paypal_new_acc_details" value="1"> <input type="hidden" id="nn_paypal_new_acc_form" name="nn_paypal_new_acc_form" value="1"> <input type="hidden" id="nn_paypal_paymentid" name="nn_paypal_paymentid" value="76"> <input type="hidden" id="paypalref_lang_before" value="Nach der erfolgreichen Überprüfung werden Sie auf die abgesicherte Novalnet-Bestellseite umgeleitet, um die Zahlung fortzusetzen.<br>Bitte schließen Sie den Browser nach der erfolgreichen Zahlung nicht, bis Sie zum Shop zurückgeleitet wurden.">  </div> </div></div>
        {/if}
    </div>
{/block}