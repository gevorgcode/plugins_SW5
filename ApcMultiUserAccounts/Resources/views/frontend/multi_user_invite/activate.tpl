{extends file='parent:frontend/account/index.tpl'}

{namespace name="frontend/account/multiuser"}

{* Register Login *}
    {block name='frontend_register_index_login'}{/block}
     {* Register advantages *}
    {block name='frontend_register_index_advantages'}{/block}

{* Main content *}
{block name="frontend_index_content"}
    <div class="is--ctl-register multiuser--activation-container">
        <div class="multiuser--activation--head">Kontoaktivierung</div>
        <div class="multiuser--activation--under-head">Bitte füllen Sie das folgende Formular aus, um Ihre Registrierung für <strong>{$multiUserInfo->getEmail()|escape}</strong> abzuschließen und Zugriff auf das Firmenkonto zu erhalten.</div>
        {if $multiUserInfoParams.redirectParams}
            <div class="multiuser--accounts--email--error alert is--error is--rounded"> 
                <div class="alert--icon"> 
                    <i class="icon--element icon--cross"></i> 
                </div>
                <div class="alert--content"> 
                    Bitte füllen Sie das Captcha-Feld korrekt aus.
                </div> 
            </div>   
        {/if}
        <div class="register--content panel content block has--border is--rounded" id="registration" data-register="true">
            <form method="post" action="https://newdev.it-nerd24.de/register/saveRegister/" class="panel register--form" id="register--form">
                
                {* personal information *}
                <div class="panel register--personal">
                    <h2 class="panel--title is--underline"> Ihre Zugangsdaten </h2>                    
                    <div class="panel--body is--wide">
                        <div class="konto--anlegen register--login-description">Bitte vervollständigen Sie Ihre persönlichen Angaben.</div>

                        <input type="hidden" name="register[personal][customer_type]" value="private">
                        <input type="hidden" value="0" name="register[personal][accountmode]" class="register--checkbox chkbox">
                        <input type="hidden" name="register[personal][email]" value="{$multiUserInfo->getEmail()|escape}">                          

                        <div class="register--salutation field--select select-field">
                            <select name="register[personal][salutation]" id="salutation" required="required" aria-required="true" class="is--required">
                                <option value="" disabled="disabled" {if !$multiUserInfoParams}selected="selected"{/if}> Anrede* </option>
                                <option value="mr" {if $multiUserInfoParams.register.personal.salutation == 'mr'}selected="selected"{/if}>Herr</option>
                                <option value="ms" {if $multiUserInfoParams.register.personal.salutation == 'ms'}selected="selected"{/if}>Frau</option>
                                <option value="not_defined" {if $multiUserInfoParams.register.personal.salutation == 'not_defined'}selected="selected"{/if}>Nicht definiert</option>
                            </select>
                        </div>

                        <div class="register--firstname">
                            <input autocomplete="section-personal given-name" name="register[personal][firstname]" type="text" required="required" aria-required="true" placeholder="Vorname*" id="firstname" value="{$multiUserInfoParams.register.personal.firstname}" class="register--field is--required"> 
                         </div>
                        <div class="register--lastname"> 
                            <input autocomplete="section-personal family-name" name="register[personal][lastname]" type="text" required="required" aria-required="true" placeholder="Nachname*" id="lastname" value="{$multiUserInfoParams.register.personal.lastname}" class="register--field is--required">
                        </div>
                        

                        <div class="register--account-information">
                            <div class="register--password"> 
                                <input name="register[personal][password]" type="password" autocomplete="new-password" required="required" aria-required="true" placeholder="Ihr Passwort*" id="register_personal_password" class="register--field password is--required"> 
                            </div>
                            <div class="register--password-description"> Ihr Passwort muss mindestens 8 Zeichen umfassen.<br>Berücksichtigen Sie Groß- und Kleinschreibung. </div>
                        </div>

                        <div class="register--phone">
                            <input autocomplete="section-personal tel" name="register[personal][phone]" type="tel" placeholder="Telefon" id="phone" value="{$multiUserInfoParams.register.personal.phone}" class="register--field">
                        </div>
                    </div>
                </div>                
                
                {* address *}
                <div class="panel register--address">
                    <h2 class="panel--title is--underline"> Ihre Adresse </h2>
                    <div class="panel--body is--wide">
                        
                        <div class="register--street"> 
                            <input autocomplete="section-billing billing street-address" name="register[billing][street]" type="text" required="required" aria-required="true" placeholder="Straße und Nr.*" id="street" value="{$multiUserInfoParams.register.billing.street}" class="register--field register--field-street is--required">
                        </div>

                        <div class="register--zip-city">
                            <input autocomplete="section-billing billing postal-code" name="register[billing][zipcode]" type="text" required="required" aria-required="true" placeholder="PLZ*" id="zipcode" value="{$multiUserInfoParams.register.billing.zipcode}" class="register--field register--spacer register--field-zipcode is--required">
                            <input autocomplete="section-billing billing address-level2" name="register[billing][city]" type="text" required="required" aria-required="true" placeholder="Ort*" id="city" value="{$multiUserInfoParams.register.billing.city}" size="25" class="register--field register--field-city is--required">
                        </div>
                        
                        {*}<div class="register--country field--select select-field">
                            <select name="register[billing][country]"
                                    data-address-type="billing"
                                    id="country"
                                    required="required"
                                    aria-required="true"
                                    class="select--country is--required{if isset($error_flags.country)} has--error{/if}">
                                {if {$Locale} eq 'de_DE'}
                                    <option value="2"
                                            selected="selected">
                                            Deutschland 
                                    </option>
                                {elseif {$Locale} eq 'de_AT'}
                                    <option value="23"
                                            selected="selected">
                                            Österreich 
                                    </option>
                                {elseif {$Locale} eq 'de_CH'}
                                    <option value="26"
                                            selected="selected">
                                            Schweiz 
                                    </option>
                                {elseif {$Locale} eq 'en_GB'}
                                    <option value="11"
                                            selected="selected">
                                            Great Britain 
                                    </option>    
                                {elseif {$Locale} eq 'fr_FR'}
                                    <option value="9"
                                            selected="selected">
                                            France
                                    </option>
                                {elseif {$Locale} eq 'es_ES'}
                                    <option value="27"
                                            selected="selected">
                                            Spain
                                    </option>
                                {elseif {$Locale} eq 'it_IT'}
                                    <option value="14"
                                            selected="selected">
                                            Italy
                                    </option>    
                                {else}
                                    <option disabled="disabled"
                                            value=""
                                            selected="selected">
                                        {s name='RegisterBillingPlaceholderCountry'}{/s}
                                        {s name="RequiredField" namespace="frontend/register/index"}{/s}
                                    </option>
                                {/if}
                                {foreach $country_list as $country}
                                    <option value="{$country.id}" {if $country.states}stateSelector="country_{$country.id}_states"{/if}>
                                        {$country.countryname}
                                    </option>
                                {/foreach}
                            </select>
                        </div>{*}

                        {assign var="selectedCountryId" value=$multiUserInfoParams.register.billing.country|default:null}

                        {if !$selectedCountryId}
                            {if $Locale == 'de_DE'}
                                {assign var="selectedCountryId" value=2}
                            {elseif $Locale == 'de_AT'}
                                {assign var="selectedCountryId" value=23}
                            {elseif $Locale == 'de_CH'}
                                {assign var="selectedCountryId" value=26}
                            {elseif $Locale == 'en_GB'}
                                {assign var="selectedCountryId" value=11}
                            {elseif $Locale == 'fr_FR'}
                                {assign var="selectedCountryId" value=9}
                            {elseif $Locale == 'es_ES'}
                                {assign var="selectedCountryId" value=27}
                            {elseif $Locale == 'it_IT'}
                                {assign var="selectedCountryId" value=14}
                            {/if}
                        {/if}

                        <div class="register--country field--select select-field">
                            <select name="register[billing][country]"
                                    data-address-type="billing"
                                    id="country"
                                    required="required"
                                    aria-required="true"
                                    class="select--country is--required{if isset($error_flags.country)} has--error{/if}">
                                
                                {if !$selectedCountryId}
                                    <option disabled="disabled" value="" selected="selected">
                                        {s name='RegisterBillingPlaceholderCountry'}{/s}
                                        {s name="RequiredField" namespace="frontend/register/index"}{/s}
                                    </option>
                                {/if}

                                {foreach $country_list as $country}
                                    <option value="{$country.id}"
                                        {if $country.states}stateSelector="country_{$country.id}_states"{/if}
                                        {if $country.id == $selectedCountryId}selected="selected"{/if}>
                                        {$country.countryname}
                                    </option>
                                {/foreach}
                            </select>
                        </div>


                        <div class="alert is--warning is--rounded is--hidden" id="billingCountryBlockedAlert">
                        <div class="alert--icon"> <i class="icon--element icon--info"></i> </div>
                        <div class="alert--content"> </div>
                        </div>
                        <div class="country-area-state-selection"> </div>
                    </div>
                </div>                
                <div class="register--required-info required_fields"> * hierbei handelt es sich um ein Pflichtfeld </div>
                <div>
                    <div class="captcha--placeholder" data-captcha="true" data-src="/widgets/Captcha/getCaptchaByName/captchaName/default" data-errormessage="Bitte füllen Sie das Captcha-Feld korrekt aus."> </div>
                    <input type="hidden" name="captchaName" value="default"> 
                </div>
                <h2 class="panel--title is--underline"> Datenschutz </h2>
                <div class="panel--body is--wide">
                    <div class="register--password-description"> Ich habe die <a title="Datenschutzbestimmungen" href="https://newdev.it-nerd24.de/custom/index/sCustom/2" target="_blank">Datenschutzbestimmungen</a> zur Kenntnis genommen. </div>
                    <div class="register--required-info1 required_fields"> * hierbei handelt es sich um ein Pflichtfeld </div>
                </div>
                <div class="register--action"> <button type="submit" class="register--submit btn is--primary is--large is--icon-right" name="Submit" data-preloader-button="true"> Weiter <i class="icon--arrow-right"></i> </button> </div>
                <input type="hidden" name="__csrf_token" value="7OK8iwgVLUnMWPlm34qFIXdXx9ZBMC">
            </form>
        </div>
    </div>      
{/block}