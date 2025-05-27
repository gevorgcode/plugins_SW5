{extends file='parent:frontend/account/index.tpl'}

{namespace name="frontend/account/multiuser"}

{* Breadcrumb *}
{block name='frontend_index_breadcrumb'}
    <nav class="content--breadcrumb block"> 
            <ul class="breadcrumb--list" role="menu" itemscope="" itemtype="http://schema.org/BreadcrumbList"> 
                <li class="breadcrumb--entry{if $breadcrumb@last} is--active{/if} breadcrumb--is-home" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                    <a class="breadcrumb--link" href="{url controller='index'}" title="{$breadcrumb.name|escape}" itemprop="item">
                        <link itemprop="url" href="{url controller='index'}" />
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="495.398px" height="495.398px" viewBox="0 0 495.398 495.398" style="enable-background:new 0 0 495.398 495.398;" xml:space="preserve"><g><g><g>
                                <path d="M487.083,225.514l-75.08-75.08V63.704c0-15.682-12.708-28.391-28.413-28.391c-15.669,0-28.377,12.709-28.377,28.391     v29.941L299.31,37.74c-27.639-27.624-75.694-27.575-103.27,0.05L8.312,225.514c-11.082,11.104-11.082,29.071,0,40.158     c11.087,11.101,29.089,11.101,40.172,0l187.71-187.729c6.115-6.083,16.893-6.083,22.976-0.018l187.742,187.747     c5.567,5.551,12.825,8.312,20.081,8.312c7.271,0,14.541-2.764,20.091-8.312C498.17,254.586,498.17,236.619,487.083,225.514z"/>
                                <path d="M257.561,131.836c-5.454-5.451-14.285-5.451-19.723,0L72.712,296.913c-2.607,2.606-4.085,6.164-4.085,9.877v120.401     c0,28.253,22.908,51.16,51.16,51.16h81.754v-126.61h92.299v126.61h81.755c28.251,0,51.159-22.907,51.159-51.159V306.79     c0-3.713-1.465-7.271-4.085-9.877L257.561,131.836z"/>
                            </g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        <span class="breadcrumb--title" itemprop="name">{s name='BreadcrumbLinkHomePageText' namespace='frontend/index/breadcrumb'}itnerd24{/s}</span>
                    </a>
                    <meta itemprop="position" content="10">
                </li>
                <li class="breadcrumb--separator" style="color: #97c933"> 
                    <i class="icon--arrow-right"></i> 
                </li> 
                <li class="breadcrumb--entry" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="breadcrumb--link" href="{url controller=Account}" title="{s namespace='frontend/invoiceDownload' name="konto"}Konto{/s}" itemprop="item"> 
                        <link itemprop="url" href="{url controller=Account}">
                        <span class="breadcrumb--title" itemprop="name">{s namespace='frontend/invoiceDownload' name="konto"}Konto{/s}</span> 
                    </a>
                    <meta itemprop="position" content="0"> 
                </li>
                <li class="breadcrumb--separator" style="color: #97c933"> 
                    <i class="icon--arrow-right"></i> 
                </li> 
                <li class="breadcrumb--entry is--active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a class="breadcrumb--link" href="{url controller=MultiUsers}" title="" itemprop="item"> 
                        <link itemprop="url" href="{url controller=MultiUsers}">
                        <span class="breadcrumb--title" itemprop="name">{s namespace='MultiUsers' name="apc_Mitarbeiterzugänge"}Mitarbeiterzugänge{/s}</span> 
                    </a>
                    <meta itemprop="position" content="0"> 
                </li> 
            </ul> 
        </nav>
{/block}

{* Main content *}
{block name="frontend_index_content"}
    <div class="multi--user--account--content account--content">        
        <div class="account--welcome panel">                
            <h1 class="panel--title">Zugänge für Ihre Mitarbeiter verwalten</h1>              
            <div class="panel--body is--wide">
                <p>Mit dem Multi-User-Konto können Sie Mitarbeitenden individuelle Zugänge zu Ihrem Firmenkonto erteilen. Definieren Sie Rollen, beschränken Sie Bestellrechte und behalten Sie die volle Kontrolle über alle Aktivitäten innerhalb Ihres Unternehmenskontos.</p>
                <p>Nutzen Sie dieses Tool, um mehrere Benutzer zu verwalten – ideal für Einkäufer, Buchhaltung oder Supportmitarbeiter.
                </p>
            </div>
        </div> 
    </div>    

    {if $multiUserAccountDisabled}
        <div class="alert is--warning is--rounded"> 
            <div class="alert--icon"> 
                <i class="icon--element icon--warning"></i> 
                </div>
                <div class="alert--content"> 
                    <h3>Multi-User-Funktion deaktiviert</h3>
                <p>
                    Die Multi-User-Funktion wurde für dieses Konto deaktiviert. Für weitere Informationen über den Grund der Deaktivierung oder bei anderen Fragen wenden Sie sich bitte an unseren Kundensupport.
                </p>
            </div> 
        </div>        
    {else}
                
        <div class="multiuser--accounts-item">
            <div class="role-info-section account--invitation-form forms--content">
                <div class="forms--headline">
                    {if $multiUserInfo.users}
                        <div class="forms--title">Mitarbeiterliste</div>
                        {if $params.successMessage2}
                            <div class="multiuser--accounts--email--error alert is--success is--rounded" id="multiuser--message--top"> 
                                <div class="alert--icon"> 
                                    <i class="icon--element icon--check"></i> 
                                </div>
                                <div class="alert--content"> 
                                    {$params.successMessage2}
                                </div> 
                            </div>      
                        {/if}
                        {if $params.errorMessage2}
                            <div class="multiuser--accounts--email--error alert is--info is--rounded" id="multiuser--message--top"> 
                                <div class="alert--icon"> 
                                    <i class="icon--element icon--info"></i> 
                                </div>
                                <div class="alert--content"> 
                                    {$params.errorMessage2}
                                </div> 
                            </div>      
                        {/if}
                        <table class="forms--table role-description-table">
                            <thead>
                                <tr>
                                    <th class="role-description-table__head">E-Mail</th>
                                    <th class="role-description-table__head">Kontostatus</th>
                                    <th class="role-description-table__head">Rolle</th>
                                    <th class="role-description-table__head">Erstellt am</th>
                                    <th class="role-description-table__head">Aktualisiert am</th>
                                    <th class="role-description-table__head">Aktionen</th>
                                    <th class="role-description-table__head">Logs</th>
                                </tr>
                            </thead>
                            <tbody>
                                {foreach $multiUserInfo.users as $user}
                                    <tr>
                                        <td class="role-description-table__cell"><strong>{$user.email}</strong></td>
                                        <td class="role-description-table__cell status_sys_name-{$user.status_sys_name}">{$user.status}</td>
                                        <td class="role-description-table__cell role--id-{$user.roleId}">{$user.role}</td>
                                        <td class="role-description-table__cell">{$user.createdAt}</td>
                                        <td class="role-description-table__cell">{$user.updatedAt}</td>
                                        <td class="role-description-table__cell">
                                            {if in_array($user.status_sys_name, ['pending', 'active', 'inactive'])}
                                                <form action="MultiUsers/editUser" method="POST">
                                                    <input type="hidden" name="multiuser_id" value="{$user.id}">
                                                    <input type="hidden" name="multiuser_email" value="{$user.email}">
                                                    <button type="submit" class="multiuser-edit-button btn is--primary">Aktion</button>
                                                </form>                                                
                                            {else}
                                                Keine Aktion
                                            {/if}                                      
                                        </td>
                                        <td class="role-description-table__cell">
                                            <form action="MultiUsers/logs" method="POST">
                                                <input type="hidden" name="multiuser_id" value="{$user.id}">
                                                <input type="hidden" name="multiuser_email" value="{$user.email}">
                                                <button type="submit" class="multiuser-edit-button btn is--primary">Logs öffnen</button>
                                            </form>     
                                        </td>
                                    </tr>
                                {/foreach}                                                      
                            </tbody>
                        </table>
                    {else}
                        <div class="forms--title">Keine Mitarbeiter hinzugefügt</div>
                        <div class="forms--text">
                            <p class="callback--tragen">Sie haben derzeit keine Mitarbeiter in Ihrem Konto hinzugefügt. Verwenden Sie das untenstehende Formular, um Ihre Kollegen einzuladen.</p> 
                        </div>
                    {/if}
                </div>
            </div>
        </div>            

        <div class="multiuser--accounts-item">
            <div class="account--invitation-form forms--content">
                <div class="forms--headline">
                    <div class="forms--title">Mitarbeiter einladen</div>
                    <div class="forms--text">
                        <p class="callback--tragen">Laden Sie einen Mitarbeiter zu Ihrem Firmenkonto ein. Geben Sie die E-Mail-Adresse ein und weisen Sie eine Rolle zu.</p> 
                        {if $params.erroremail}
                            <div class="multiuser--accounts--email--error alert is--error is--rounded" id="multiuser--message--top"> 
                                <div class="alert--icon"> 
                                    <i class="icon--element icon--cross"></i> 
                                </div>
                                <div class="alert--content"> 
                                    {$params.erroremail}
                                </div> 
                            </div>      
                        {/if}
                        {if $params.successMessage}
                            <div class="multiuser--accounts--email--error alert is--success is--rounded" id="multiuser--message--top"> 
                                <div class="alert--icon"> 
                                    <i class="icon--element icon--check"></i> 
                                </div>
                                <div class="alert--content"> 
                                    {$params.successMessage}
                                </div> 
                            </div>      
                        {/if}
                        <p class="callback--ihre">Ihre Daten</p>
                    </div>
                </div>                  
                <div class="forms--container">
                    <div class="panel--body">
                        <form id="support" name="support" class="" method="post" action="/MultiUsers/invite">
                            <div>
                                <input type="email" name="email" id="invite-email" required placeholder="E-Mail-Adresse des Mitarbeiters*" value="{$params.email}" class="{if $params.erroremail}has--error{/if}">
                            </div>
                            <div class="form--field">
                                <select name="role" id="invite-role" required>
                                    <option value="" disabled="disabled" selected="selected">Rolle im Konto* </option>
                                    {foreach $multiUserInfo.roles as $multiUserRole}
                                        {if $multiUserRole.id > 1}
                                            <option value="{$multiUserRole.id}" {if $params.role == $multiUserRole.id}selected="selected"{/if}>{$multiUserRole.name}</option>
                                        {/if}
                                    {/foreach}                            
                                </select>
                            </div>
                            <textarea name="comment" id="comment" placeholder="Fügen Sie bei Bedarf einen Kommentar hinzu (optional)">{$params.comment}</textarea>
                            <div class="forms--required">* hierbei handelt es sich um ein Pflichtfeld</div>
                            <p class="privacy-information block-group"> Ich habe die <a title="Datenschutzbestimmungen"
                                    href="{url controller=custom action=index sCustom=2}" target="_blank">Datenschutzbestimmungen</a>
                                zur Kenntnis genommen. </p>
                            <div class="form--actions">
                                <button type="submit" class="btn is--secondary">Einladen</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="multiuser--accounts-item">
            <div class="role-info-section account--invitation-form forms--content">
                <div class="forms--headline">
                    <div class="forms--title">Rollenbeschreibung</div>
                    <table class="forms--table role-description-table">
                        <thead>
                            <tr>
                                <th class="role-description-table__head">Rolle</th>
                                <th class="role-description-table__head">Beschreibung</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $multiUserInfo.roles as $multiUserRole}
                                {if $multiUserRole.id > 1}
                                    <tr>
                                        <td class="role-description-table__cell"><strong>{$multiUserRole.name}</strong></td>
                                        <td class="role-description-table__cell">{$multiUserRole.description}</td>
                                    </tr>
                                {/if}
                            {/foreach}     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>   

        <div class="multiuser--accounts-item">
            <div class="role-info-section account--invitation-form forms--content">
                <div class="forms--headline">
                    <div class="forms--title">Statusbeschreibung</div>
                    <table class="forms--table role-description-table">
                        <thead>
                            <tr>
                                <th class="role-description-table__head">Status</th>
                                <th class="role-description-table__head">Beschreibung</th>
                            </tr>
                        </thead>
                        <tbody>
                            {foreach $multiUserInfo.statuses as $multiUserStatusKey => $multiUserStatus}                                
                                <tr>
                                    <td class="role-description-table__cell status_sys_name-{$multiUserStatusKey}"><strong>{$multiUserStatus.name}</strong></td>
                                    <td class="role-description-table__cell">{$multiUserStatus.description}</td>
                                </tr>                                
                            {/foreach}     
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
    {/if}
{/block}