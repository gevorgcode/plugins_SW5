{extends file='parent:frontend/register/index.tpl'}

{namespace name="frontend/account/multiuser"}

{* Register Login *}
    {block name='frontend_register_index_login'}{/block}
     {* Register advantages *}
    {block name='frontend_register_index_advantages'}{/block}

{* Main content *}
{block name="frontend_index_content"}
    <div class="is--ctl-register">
        <div class="register--content panel content block has--border is--rounded" id="registration" data-register="true">
            <form method="post" action="https://newdev.it-nerd24.de/MultiUserInvite/saveRegister/sTarget//sTargetAction/" class="panel register--form" id="register--form">
                <div class="panel register--personal">
                    <h2 class="panel--title is--underline"> Ich bin Neukunde </h2>
                    <div class="panel--body is--wide">
                        <div class="konto--anlegen register--login-description">Jetzt Konto anlegen</div>
                        <div class="register--customertype">
                        <div class="select-field">
                            <select id="register_personal_customer_type" name="register[personal][customer_type]" required="required" aria-required="true" class="is--required">
                                <option value="" disabled="disabled" selected="selected"> Ich bin* </option>
                                <option value="private"> Privatkunde </option>
                                <option value="business"> Firma </option>
                            </select>
                        </div>
                        </div>
                        <div class="register--salutation field--select select-field">
                        <select name="register[personal][salutation]" id="salutation" required="required" aria-required="true" class="is--required">
                            <option value="" disabled="disabled" selected="selected"> Anrede* </option>
                            <option value="mr">Herr</option>
                            <option value="ms">Frau</option>
                            <option value="not_defined">Nicht definiert</option>
                        </select>
                        </div>
                        <div class="register--firstname"> <input autocomplete="section-personal given-name" name="register[personal][firstname]" type="text" required="required" aria-required="true" placeholder="Vorname*" id="firstname" value="" class="register--field is--required"> </div>
                        <div class="register--lastname"> <input autocomplete="section-personal family-name" name="register[personal][lastname]" type="text" required="required" aria-required="true" placeholder="Nachname*" id="lastname" value="" class="register--field is--required"> </div>
                        <input type="hidden" value="0" name="register[personal][accountmode]" class="register--checkbox chkbox"> 
                        <div class="register--email"> <input autocomplete="section-personal email" name="register[personal][email]" type="email" required="required" aria-required="true" placeholder="Ihre E-Mail-Adresse*" id="register_personal_email" value="" class="register--field email is--required"> </div>
                        <div class="register--account-information">
                        <div class="register--password"> <input name="register[personal][password]" type="password" autocomplete="new-password" required="required" aria-required="true" placeholder="Ihr Passwort*" id="register_personal_password" class="register--field password is--required"> </div>
                        <div class="register--password-description"> Ihr Passwort muss mindestens 8 Zeichen umfassen.<br>Berücksichtigen Sie Groß- und Kleinschreibung. </div>
                        </div>
                        <div class="register--phone"> <input autocomplete="section-personal tel" name="register[personal][phone]" type="tel" placeholder="Telefon" id="phone" value="" class="register--field"> </div>
                    </div>
                </div>                
                <div class="panel register--address">
                    <h2 class="panel--title is--underline"> Ihre Adresse </h2>
                    <div class="panel--body is--wide">
                        <div class="register--street"> <input autocomplete="section-billing billing street-address" name="register[billing][street]" type="text" required="required" aria-required="true" placeholder="Straße und Nr.*" id="street" value="" class="register--field register--field-street is--required"> </div>
                        <div class="register--zip-city"> <input autocomplete="section-billing billing postal-code" name="register[billing][zipcode]" type="text" required="required" aria-required="true" placeholder="PLZ*" id="zipcode" value="" class="register--field register--spacer register--field-zipcode is--required"> <input autocomplete="section-billing billing address-level2" name="register[billing][city]" type="text" required="required" aria-required="true" placeholder="Ort*" id="city" value="" size="25" class="register--field register--field-city is--required"> </div>
                        <div class="register--country field--select select-field">
                        <select name="register[billing][country]" data-address-type="billing" id="country" required="required" aria-required="true" class="select--country is--required">
                            <option value="2" selected="selected"> Deutschland </option>
                        </select>
                        </div>
                        <div class="alert is--warning is--rounded is--hidden" id="billingCountryBlockedAlert">
                        <div class="alert--icon"> <i class="icon--element icon--info"></i> </div>
                        <div class="alert--content"> </div>
                        </div>
                        <div class="country-area-state-selection"> </div>
                        <div class="register--alt-shipping"> <input name="register[billing][shippingAddress]" type="checkbox" id="register_billing_shippingAddress" value="1"> <label for="register_billing_shippingAddress">Die <strong>Lieferadresse</strong> weicht von der Rechnungsadresse ab.</label> </div>
                    </div>
                </div>
                <div class="panel register--shipping is--hidden">
                    <h2 class="panel--title is--underline"> Ihre abweichende Lieferadresse </h2>
                    <div class="panel--body is--wide">
                        <div class="register--salutation field--select select-field">
                        <select name="register[shipping][salutation]" id="salutation2" class="normal is--required">
                            <option value="" disabled="disabled" selected="selected">Anrede*</option>
                            <option value="mr">Herr</option>
                            <option value="ms">Frau</option>
                            <option value="not_defined">Nicht definiert</option>
                        </select>
                        </div>
                        <div class="register--companyname"> <input autocomplete="section-shipping shipping organization" name="register[shipping][company]" type="text" placeholder="Firma" id="company2" value="" class="register--field"> </div>
                        <div class="register--department"> <input autocomplete="section-shipping shipping organization-title" name="register[shipping][department]" type="text" placeholder="Abteilung" id="department2" value="" class="register--field "> </div>
                        <div class="register--firstname"> <input autocomplete="section-shipping shipping given-name" name="register[shipping][firstname]" type="text" aria-required="true" placeholder="Vorname*" id="firstname2" value="" class="register--field is--required"> </div>
                        <div class="register--lastname"> <input autocomplete="section-shipping shipping family-name" name="register[shipping][lastname]" type="text" aria-required="true" placeholder="Nachname*" id="lastname2" value="" class="register--field is--required"> </div>
                        <div class="register--street"> <input autocomplete="section-shipping shipping street-address" name="register[shipping][street]" type="text" aria-required="true" placeholder="Straße und Nr.*" id="street2" value="" class="register--field register--field-street is--required"> </div>
                        <div class="register--zip-city"> <input autocomplete="section-shipping shipping postal-code" name="register[shipping][zipcode]" type="text" aria-required="true" placeholder="PLZ*" id="zipcode2" value="" class="register--field register--spacer register--field-zipcode is--required"> <input autocomplete="section-shipping shipping address-level2" name="register[shipping][city]" type="text" aria-required="true" placeholder="Ort*" id="city2" value="" size="25" class="register--field register--field-city is--required"> </div>
                        <div class="register--shipping-country field--select select-field">
                        <select name="register[shipping][country]" data-address-type="shipping" id="country_shipping" aria-required="true" class="select--country is--required">
                            <option value="" disabled="disabled" selected="selected"> Land* </option>
                        </select>
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