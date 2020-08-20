{extends file='parent:frontend/index/index.tpl'}
 
{* Sidebar left *}
{block name='frontend_index_content_left'}{/block}

{block name='frontend_index_content'}  
  <div class="software--code-download">
       <div class="sd--headline-title">
           <h2 class="sd--title">{s name='softCodevielen' namespace='frontend/softwareCode'}Vielen Dank für Ihren Einkauf bei license-now!{/s}</h2>
           <h3 class="sd--headline">{s name='softCodeheadline' namespace='frontend/softwareCode'}Fast geschafft, jetzt nur noch Ihre Software downloaden und Ihren persönlichen Produktschlüssel eingeben.{/s}</h3>
       </div>

       <div class="sd--software--content">
           <div class="sd--product-img">
               <img src="{$sArticle.image.thumbnails['1'].source}" alt="product image">
           </div>
           <div class="sd--product-info">
                <img src="{$sArticle.supplierImg}" alt="supplier logo" class="sd--supplier--logo">
                <p class="sd--product-name">{$sArticle.articleName}</p>
                <span class="sd--btn-download btn is--primary"><span>{s name='softCodeihrDownload' namespace='frontend/softwareCode'}Ihre Software als Download{/s}</span> <span> <i class="icon--download"></i> </span> </span>
                {if {$esdAttr}}
                    <div class="software--download-links" style="display: none">
                        {if $Locale == de_DE || $Locale == de_AT || $Locale == de_CH}
                            {if {$esdAttr.file_1}}
                               <p><a href="{$esdAttr.file_1}" target="_blank">{$esdAttr.text_1}</a></p>                            
                            {/if}
                            {if {$esdAttr.file_2}}
                                <p><a href="{$esdAttr.file_2}" target="_blank">{$esdAttr.text_2}</a></p>
                            {/if}
                            {if {$esdAttr.file_3}}
                                <p><a href="{$esdAttr.file_3}" target="_blank">{$esdAttr.text_3}</a></p>
                            {/if}
                            {if {$esdAttr.file_4}}
                                <p><a href="{$esdAttr.file_4}" target="_blank">{$esdAttr.text_4}</a></p>
                            {/if}
                        {/if}
                         
                        {if $Locale == en_GB} 
                            {if {$esdAttr.file_5}}
                               <p><a href="{$esdAttr.file_5}" target="_blank">{$esdAttr.text_5}</a></p>                            
                            {/if}
                            {if {$esdAttr.file_6}}
                                <p><a href="{$esdAttr.file_6}" target="_blank">{$esdAttr.text_6}</a></p>
                            {/if}
                        {/if}
                        {if $Locale == fr_FR}
                            {if {$esdAttr.file_7}}
                                <p><a href="{$esdAttr.file_7}" target="_blank">{$esdAttr.text_7}</a></p>
                            {/if}
                            {if {$esdAttr.file_8}}
                                <p><a href="{$esdAttr.file_8}" target="_blank">{$esdAttr.text_8}</a></p>
                            {/if}
                        {/if}
                    </div>
                {/if}
                
                <p class="sd--lizenz--code-p">{s name='softCodeihreLizenz' namespace='frontend/softwareCode'}Ihr persönlicher Produktschlüssel{/s}</p>
                <div class="sd--lizenz--code email-addres" data-copy="{$productKey}">
                    {$productKey}
                    <div class="talktext hide--popup is--hidden" style="opacity: 0;">
                        <p class="email_copied">{s name='codeCopied' namespace='frontend/softwareCode'}Code kopiert{/s} </p>
                    </div>
                </div>
                
                <form class="action--button-print print--page-button">
                    <button type="button" name="button" class="sd--product--print product--action product--print">
                    <span class="svg--box-print">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 482.5 482.5" style="enable-background:new 0 0 482.5 482.5;" xml:space="preserve"> <g> <g> <path d="M399.25,98.9h-12.4V71.3c0-39.3-32-71.3-71.3-71.3h-149.7c-39.3,0-71.3,32-71.3,71.3v27.6h-11.3 c-39.3,0-71.3,32-71.3,71.3v115c0,39.3,32,71.3,71.3,71.3h11.2v90.4c0,19.6,16,35.6,35.6,35.6h221.1c19.6,0,35.6-16,35.6-35.6 v-90.4h12.5c39.3,0,71.3-32,71.3-71.3v-115C470.55,130.9,438.55,98.9,399.25,98.9z M121.45,71.3c0-24.4,19.9-44.3,44.3-44.3h149.6 c24.4,0,44.3,19.9,44.3,44.3v27.6h-238.2V71.3z M359.75,447.1c0,4.7-3.9,8.6-8.6,8.6h-221.1c-4.7,0-8.6-3.9-8.6-8.6V298h238.3 V447.1z M443.55,285.3c0,24.4-19.9,44.3-44.3,44.3h-12.4V298h17.8c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-330 c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h19.9v31.6h-11.3c-24.4,0-44.3-19.9-44.3-44.3v-115c0-24.4,19.9-44.3,44.3-44.3h316 c24.4,0,44.3,19.9,44.3,44.3V285.3z"></path> <path d="M154.15,364.4h171.9c7.5,0,13.5-6,13.5-13.5s-6-13.5-13.5-13.5h-171.9c-7.5,0-13.5,6-13.5,13.5S146.75,364.4,154.15,364.4 z"></path> <path d="M327.15,392.6h-172c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h171.9c7.5,0,13.5-6,13.5-13.5S334.55,392.6,327.15,392.6z"></path> <path d="M398.95,151.9h-27.4c-7.5,0-13.5,6-13.5,13.5s6,13.5,13.5,13.5h27.4c7.5,0,13.5-6,13.5-13.5S406.45,151.9,398.95,151.9z"></path> </g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>
                    </span>
                    {s name='softCodeDrucken' namespace='frontend/softwareCode'}Zusammenfassung Drucken{/s}                    
                    </button>
                </form>
           </div>           
       </div>
       
       <div class="emotion--wrapper" data-controllerurl="/widgets/emotion/index/emotionId/228/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
       
       
       <div class="sd-custom-form">
            <p class="form--software-code-title">{s name='softCodeTragen' namespace='frontend/softwareCode'}Tragen Sie sich ein – wir senden Ihnen den Aktivierungsschlüssel und eine Anleitung zu.{/s}</p>

            <div class="sd--forms--content forms--content ">
                <div class="forms--headline panel panel--body is--wide has--border is--rounded">
                    <div class="forms--text">
                        <h2 class="panel--title is--underline">{s name='softCodeFormIhreDaten' namespace='frontend/softwareCode'}Ihre Daten{/s}</h2>
                    </div> 
                </div> 
                <div class="software--code-forms--container forms--container panel has--border is--rounded">
                    <div class="panel--title is--underline">{s name='softCodeFormTitle' namespace='frontend/softwareCode'}Software-code{/s}</div>
                        <div class="panel--body">
                            <form id="support" name="support" class="" method="post" action="{url controller=forms action='index' id='26'}" enctype="multipart/form-data">
                                <input type="hidden" name="forceMail" value="0">
                                <div class="forms--inner-form panel--body"> 
                                    <div> 
                                        <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="name" placeholder="{s name='softCodePlaceholderName' namespace='frontend/softwareCode'}Name*{/s}" name="name"> 
                                    </div>
                                    <div> 
                                        <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="email" placeholder="{s name='softCodePlaceholderEmail' namespace='frontend/softwareCode'}Ihre E-Mail-Adresse*{/s}" name="email"> 
                                    </div>
                                    <div> 
                                        <input type="text" class="normal " value="" id="telefon" placeholder="{s name='softCodePlaceholderTelephon' namespace='frontend/softwareCode'}Telefon{/s}" name="telefon"> 
                                    </div> 
                                    <div>
                                        <input type="text" class="normal is--required required" required="required" aria-required="true" value="{$Softwarecode}" id="softwarecode" placeholder="{s name='softCodePlaceholderSoftwareCode' namespace='frontend/softwareCode'}Software-code*{/s}" name="softwarecode"> 
                                    </div>
                                    <div class="forms--captcha">
                                        <div class="captcha--placeholder" data-src="/widgets/Captcha">
                                        </div>
                                    </div>
                                    <div class="forms--required">
                                        {s name='softCodeformhierbei' namespace='frontend/softwareCode'}* hierbei handelt es sich um ein Pflichtfeld{/s}
                                    </div>
                                    <p class="privacy-information input--checkbox-div">
                                        <input name="privacy-checkbox" type="checkbox" id="privacy-checkbox" required="required" aria-required="true" value="1" class="is--required">
                                        <span class="input--state checkbox--state">&nbsp;</span>  
                                        <label for="privacy-checkbox">
                                           {s name='softCodeFormJa' namespace='frontend/softwareCode'}Ja, ich habe die{/s}
                                            <a title="data protection information" href="/custom/index/sCustom/52" target="_blank">{s name='softCodeFormDatensch' namespace='frontend/softwareCode'}Datenschutzbestimmungen{/s}</a>
                                            {s name='softCodeFormGelesen' namespace='frontend/softwareCode'}gelesen{/s}
                                        </label>
                                     </p> 
                                     <div class="buttons"> 
                                        <button class="btn is--primary is--icon-right" type="submit" name="Submit" value="submit">
                                            {s name='softCodeFormUndAb' namespace='frontend/softwareCode'}Und ab die Post{/s}
                                            <i class="icon--arrow-right"></i>
                                        </button>
                                    </div> 
                                 </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="sd-custom-form form--question">
            <p class="form--software-code-title">{s name='softCodequestion' namespace='frontend/softwareCode'}Wenn Sie Fragen haben, schreiben Sie hier.{/s}</p>

            <div class="sd--forms--content forms--content ">
                <div class="forms--headline panel panel--body is--wide has--border is--rounded">
                    <div class="forms--text">
                        <h2 class="panel--title is--underline">{s name='softCodeFormIhreDaten' namespace='frontend/softwareCode'}Ihre Daten{/s}</h2>
                    </div> 
                </div> 
                <div class="software--code-forms--container forms--container panel has--border is--rounded">
                    <div class="panel--title is--underline">{s name='softCodeFormTitle' namespace='frontend/softwareCode'}Software-code{/s}</div>
                        <div class="panel--body">
                            <form id="support" name="support" class="" method="post" action="{url controller=forms action='index' id='27'}" enctype="multipart/form-data">
                                <input type="hidden" name="forceMail" value="0">
                                <div class="forms--inner-form panel--body"> 
                                    <div> 
                                        <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="name" placeholder="{s name='softCodePlaceholderName' namespace='frontend/softwareCode'}Name*{/s}" name="name"> 
                                    </div>
                                    <div> 
                                        <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="email" placeholder="{s name='softCodePlaceholderEmail' namespace='frontend/softwareCode'}Ihre E-Mail-Adresse*{/s}" name="email"> 
                                    </div>
                                    <div> 
                                        <input type="text" class="normal " value="" id="telefon" placeholder="{s name='softCodePlaceholderTelephon' namespace='frontend/softwareCode'}Telefon{/s}" name="telefon"> 
                                    </div> 
                                    <div>
                                        <input type="text" class="normal is--required required" required="required" aria-required="true" value="{$Softwarecode}" id="softwarecode" placeholder="{s name='softCodePlaceholderSoftwareCode' namespace='frontend/softwareCode'}Software-code*{/s}" name="softwarecode"> 
                                    </div>
                                    <div class="textarea"> 
                                        <textarea class="normal is--required required" id="textarea" placeholder="{s name='softCodePlaceholderComment' namespace='frontend/softwareCode'}Kommentar*{/s}" name="textarea" required="required" aria-required="true">

                                        </textarea> 
                                    </div>
                                    <div>
                                        <input type="hidden" class="normal " value="{$b2bemail}" id="b2bemail" placeholder="b2bemail" name="b2bemail"> 
                                    </div>
                                    <div class="forms--captcha">
                                        <div class="captcha--placeholder" data-src="/widgets/Captcha">
                                        </div>
                                    </div>
                                    <div class="forms--required">
                                        {s name='softCodeformhierbei' namespace='frontend/softwareCode'}* hierbei handelt es sich um ein Pflichtfeld{/s}
                                    </div>
                                    <p class="privacy-information input--checkbox-div">
                                        <input name="privacy-checkbox" type="checkbox" id="privacy-checkbox" required="required" aria-required="true" value="1" class="is--required">
                                        <span class="input--state checkbox--state">&nbsp;</span>  
                                        <label for="privacy-checkbox">
                                           {s name='softCodeFormJa' namespace='frontend/softwareCode'}Ja, ich habe die{/s}
                                            <a title="data protection information" href="/custom/index/sCustom/52" target="_blank">{s name='softCodeFormDatensch' namespace='frontend/softwareCode'}Datenschutzbestimmungen{/s}</a>
                                            {s name='softCodeFormGelesen' namespace='frontend/softwareCode'}gelesen{/s}
                                        </label>
                                     </p> 
                                     <div class="buttons"> 
                                        <button class="btn is--primary is--icon-right" type="submit" name="Submit" value="submit">
                                            {s name='softCodeFormUndAb' namespace='frontend/softwareCode'}Und ab die Post{/s}
                                            <i class="icon--arrow-right"></i>
                                        </button>
                                    </div> 
                                 </div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>

         {if {!$sUserLoggedIn}}
              <h2 class="software--code-login-title">{s name='softCodeloginTitle' namespace='frontend/softwareCode'}Einkauf speichern und Kunde werden{/s}</h2>
                {$sTarget = 'account'}
                {$sTargetAction = 'index'}
                <div class="sd-login-container">
                     {include file="frontend/register/login.tpl" }
                    {* Register advantages *}
                    {block name='frontend_register_index_advantages'}
                        <div class="register--advantages block">
                            {block name='frontend_register_index_advantages_title'}
                                <h2 class="panel--title">{s name='RegisterInfoAdvantagesTitle' namespace='frontend/register/index'}{/s}</h2>
                            {/block}
                            {block name='frontend_index_content_advantages_list'}
                                <ul class="list--unordered is--checked register--advantages-list">
                                    {block name='frontend_index_content_advantages_entry1'}
                                        <li class="register--advantages-entry">
                                            {s name='RegisterInfoAdvantagesEntry1' namespace='frontend/register/index'}{/s}
                                        </li>
                                    {/block}

                                    {block name='frontend_index_content_advantages_entry2'}
                                        <li class="register--advantages-entry">
                                            {s name='RegisterInfoAdvantagesEntry2' namespace='frontend/register/index'}{/s}
                                        </li>
                                    {/block}

                                    {block name='frontend_index_content_advantages_entry3'}
                                        <li class="register--advantages-entry">
                                            {s name='RegisterInfoAdvantagesEntry3' namespace='frontend/register/index'}{/s}
                                        </li>
                                    {/block}

                                    {block name='frontend_index_content_advantages_entry4'}
                                        <li class="register--advantages-entry">
                                            {s name='RegisterInfoAdvantagesEntry4' namespace='frontend/register/index'}{/s}
                                        </li>
                                    {/block}
                                </ul>
                            {/block}
                        </div>
                    {/block}
                </div>       
                {block name='frontend_register_index_registration'}
                    <div class="sd--register--content register--content panel content block has--border is--rounded{if $errors.occurred} is--collapsed{/if}" id="registration" data-register="true" style="display: block">


                        {block name='frontend_register_index_form'}

                            <form method="post" action="{url controller=register action=saveRegister sTarget=$sTarget sTargetAction=$sTargetAction}" class="panel register--form" id="register--form">

                                {* Invalid hash while option verification process *}
                                {block name='frontend_register_index_form_optin_invalid_hash'}
                                    {if $smarty.get.optinhashinvalid && ({config name=optinregister} || {config name=optinaccountless})}
                                        {s name="RegisterInfoInvalidHash" assign="snippetRegisterInfoInvalidHash"}{/s}
                                        {include file="frontend/_includes/messages.tpl" type="error" content=$snippetRegisterInfoInvalidHash}
                                    {/if}
                                {/block}

                                {block name='frontend_register_index_form_captcha_fieldset'}
                                    {include file="frontend/register/error_message.tpl" error_messages=$errors.captcha}
                                {/block}

                                {block name='frontend_register_index_form_personal_fieldset'}
                                    {include file="frontend/register/error_message.tpl" error_messages=$errors.personal}
                                    {include file="frontend/register/personal_fieldset.tpl" form_data=$register.personal error_flags=$errors.personal}
                                {/block}

                                {block name='frontend_register_index_form_billing_fieldset'}
                                    {include file="frontend/register/error_message.tpl" error_messages=$errors.billing}
                                    {include file="frontend/register/billing_fieldset.tpl" form_data=$register.billing error_flags=$errors.billing country_list=$countryList}
                                {/block}

                                {block name='frontend_register_index_form_shipping_fieldset'}
                                    {include file="frontend/register/error_message.tpl" error_messages=$errors.shipping}
                                    {include file="frontend/register/shipping_fieldset.tpl" form_data=$register.shipping error_flags=$errors.shipping country_list=$countryList}
                                {/block}

                                {* @deprecated Block will be excluded in 5.7 *}
                                {* It has been replaced by "frontend_register_index_form_privacy" below *}
                                {if !$update}
                                    {block name='frontend_register_index_input_privacy'}{/block}
                                {/if}

                                {block name='frontend_register_index_form_required'}
                                    {* Required fields hint *}
                                    <div class="register--required-info required_fields">
                                        {s name='RegisterPersonalRequiredText' namespace='frontend/register/personal_fieldset'}{/s}
                                    </div>
                                {/block}

                                {* Captcha *}
                                {block name='frontend_register_index_form_captcha'}
                                    {$captchaName = {config name=registerCaptcha}}
                                    {$captchaHasError = $errors.captcha}
                                    {include file="widgets/captcha/custom_captcha.tpl" captchaName=$captchaName captchaHasError=$captchaHasError}
                                {/block}

                                {* Data protection information *}
                                {if !$update}
                                    {block name="frontend_register_index_form_privacy"}
                                        {if {config name=ACTDPRTEXT} || {config name=ACTDPRCHECK}}
                                            {block name="frontend_register_index_form_privacy_title"}
                                                <h2 class="panel--title is--underline">
                                                    {s name="PrivacyTitle" namespace="frontend/index/privacy"}{/s}
                                                </h2>
                                            {/block}
                                            <div class="panel--body is--wide">
                                                {block name="frontend_register_index_form_privacy_content"}
                                                    <div class="register--password-description input--checkbox-div">
                                                        {if {config name=ACTDPRCHECK}}
                                                            {* Privacy checkbox *}
                                                            {block name="frontend_register_index_form_privacy_content_checkbox"}
                                                                <input name="register[personal][dpacheckbox]" type="checkbox" id="dpacheckbox"{if $form_data.dpacheckbox} checked="checked"{/if} required="required" aria-required="true" value="1" class="is--required" />
                                                                <span class="input--state checkbox--state">&nbsp;</span>  
                                                                <label for="dpacheckbox">
                                                                    {s name="PrivacyText" namespace="frontend/index/privacy"}{/s}
                                                                </label>
                                                            {/block}
                                                        {else}
                                                            {block name="frontend_register_index_form_privacy_content_text"}
                                                                {s name="PrivacyText" namespace="frontend/index/privacy"}{/s}
                                                            {/block}
                                                        {/if}
                                                    </div>
                                                {/block}
                                            </div>
                                        {/if}
                                    {/block}
                                {/if}

                                {block name='frontend_register_index_form_submit'}
                                    {* Submit button *}
                                    {if $productKey}
                                        <input type="hidden" name="soft_order_serial_id" value="{$serialId}">
                                    {/if} 
                                    <div class="register--action">
                                        <button type="submit" class="register--submit btn is--primary is--large is--icon-right" name="Submit">{s name="RegisterIndexNewActionSubmit" namespace="frontend/register/index"}{/s} <i class="icon--arrow-right"></i></button>
                                    </div>
                                {/block}
                            </form>
                        {/block}
                    </div>
                {/block}
            </div>
         {/if}

       
{/block}




















