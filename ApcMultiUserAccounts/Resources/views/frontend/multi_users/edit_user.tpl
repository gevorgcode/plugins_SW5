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
    <div class="account--invitation-form forms--content">
        <div class="forms--headline">
            <div class="forms--title">Mitarbeiter bearbeiten</div>
            <div class="forms--text">
                <p class="callback--tragen">Bearbeiten Sie die Informationen des Mitarbeiters. Sie können den Status oder die Rolle ändern, sofern erlaubt.</p>
                <div class="multiuser--accounts--email--error alert is--warning is--rounded"> 
                    <div class="alert--icon"> 
                        <i class="icon--element icon--warning"></i> 
                    </div>
                    <div class="alert--content"> 
                        {if in_array($user.status_sys_name, ['active', 'inactive'])}
                            Wenn der Status auf ‚Gelöscht‘ geändert wird, ist es später nicht mehr möglich, den Zugriff für diesen Benutzer wiederherzustellen.
                        {elseif $user.status_sys_name == 'pending'}
                            Wenn der Status auf ‚Abgelehnt‘ geändert wird, ist es später nicht mehr möglich, den Zugriff für diesen Benutzer wiederherzustellen.
                        {/if}
                    </div> 
                </div>   
                <p class="callback--ihre">Benutzerdaten</p>
            </div>
        </div>

        <div class="forms--container">
            <div class="panel--body">
                <form method="post" action="/MultiUsers/edit">
                    <input type="hidden" name="multiuser_id" value="{$user.id}">
                    <input type="hidden" name="multiuser_email" value="{$user.email}">

                    <div class="form--field">
                        <label for="email">E-Mail</label>
                        <input type="email" name="email" id="email" value="{$user.email}" disabled>
                    </div>

                    {if in_array($user.status_sys_name, ['active', 'inactive'])}
                        <div class="form--field">
                            <label for="status">Kontostatus</label>
                            <select name="status" id="status">
                                <option value="active" {if $user.status_sys_name == 'active'}selected{/if}>Aktiv</option>
                                <option value="inactive" {if $user.status_sys_name == 'inactive'}selected{/if}>Inaktiv</option>
                                <option value="deleted">Gelöscht</option>
                            </select>
                        </div>

                        <div class="form--field">
                            <label for="role">Rolle</label>
                            <div class="form--field">
                                <select name="role" id="invite-role" required>                            
                                    {foreach $roles as $role}
                                        {if $role.system_name != 'admin'}
                                            <option value="{$role.system_name}" {if $user.roleId == $role.id}selected="selected"{/if}>{$role.name}</option>
                                        {/if}
                                    {/foreach}                            
                                </select>
                            </div>
                        </div>
                    
                    {elseif $user.status_sys_name == 'pending'}
                        <div class="form--field">
                            <label for="status">Kontostatus</label>
                            <select name="status" id="status">
                                <option value="pending" selected>Ausstehend</option>
                                <option value="rejected">Abgelehnt</option>
                            </select>
                        </div>                                   
                    {/if}

                    <div class="form--actions">
                        <button type="submit" class="btn is--primary">Speichern</button>
                    </div>
                </form>
            </div>
        </div>        
    </div>

    {if $user.status_sys_name == 'pending'}
        <div class="account--invitation-form forms--content account--invitation-form-resend">
            <div class="forms--headline">
                <div class="forms--title">Einladung erneut senden</div>
                <div class="forms--text">
                    <p class="callback--tragen">Wenn der Mitarbeiter die Einladung nicht erhalten hat, können Sie sie hier erneut versenden.</p>
                    <p class="callback--ihre">Einladungsoptionen</p>
                </div>
            </div>


            <div class="forms--container">
                <div class="panel--body">
                    <div class="multiuser--edit--resend-email">
                        <form action="MultiUsers/resend" method="post">
                            <input type="hidden" name="multiuser_id" value="{$user.id}">
                            <input type="hidden" name="multiuser_email" value="{$user.email}">
                            <div class="form--field">
                                <label for="email">E-Mail</label>
                                <input type="email" name="email" id="email" value="{$user.email}" disabled>
                            </div>
                            <textarea name="comment" id="comment" placeholder="Fügen Sie bei Bedarf einen Kommentar hinzu (optional)"></textarea>
                            <div class="form--actions">
                                <button type="submit" class="btn is--primary">Einladung erneut senden</button>
                            </div>    
                        </form>
                    </div>
                </div>
            </div>        
        </div>
    {/if}    
{/block}

