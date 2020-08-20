{extends file='parent:frontend/account/index.tpl'}

{namespace name="ApsB2b/frontend"}




{* Newsletter settings *}
{block name="frontend_account_index_newsletter_settings"}{/block}

{block name="frontend_index_breadcrumb_suffix"}
    <li role="none" class="breadcrumb--separator">
        <i class="icon--arrow-right"></i>
    </li>
    <li class="breadcrumb--entry gets--is--active" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"> 
        <a class="breadcrumb--link" href="" title="Kundenkonto" itemprop="item"> 
            <link itemprop="url" href=""> 
            <span class="breadcrumb--title" itemprop="name">{s name="geschaftskunde"}Geschäftskunde{/s}</span> 
        </a> 
        <meta itemprop="position" content="0"> 
    </li>
{/block}

{* Welcome text *}
{block name="frontend_account_index_welcome"}
    <div class="getse--account--welcome account--welcome panel">
        <h2 class="panel--title">{s name="geschaftskunde"}Geschäftskunde{/s}</h2>    
        <div class="panel--body is--wide">
            <span class="getse--undertitle">{s name="geseundertitle"}Werden Sie unser Partner und verwalten Sie hier Ihren Geschäftskunden-Bereich{/s}</span>
        </div>
    </div>
    <div class="getse--account--hidden">
         {$smarty.block.parent}
    </div>   
{/block}

{* General user informations *}
{block name="frontend_account_index_info"}
    <div class="account--info account--box panel has--border is--rounded">
        {block name="frontend_account_index_info_headline"}
            <h2 class="panel--title is--underline">{s name="AccountHeaderBasic"}Geschäftskunden Rechnungsadresse{/s}</h2>
        {/block}
        {block name="frontend_account_index_info_content"}
            <div class="panel--body is--wide">
                <p>
                    {$sUserData.additional.user.salutation|salutation}
                    {if {config name="displayprofiletitle"}}
                        {$sUserData.additional.user.title|escapeHtml}<br/>
                    {/if}
                    {$sUserData.additional.user.firstname|escapeHtml} {$sUserData.additional.user.lastname|escapeHtml}<br />
                    {if $sUserData.additional.user.birthday}
                        {$sUserData.additional.user.birthday|date:'dd.MM.y'}<br />
                    {/if}
                    {$sUserData.additional.user.email|escapeHtml}
                </p>
            </div>
        {/block}
        {block name="frontend_account_index_info_actions"}
            <div class="panel--actions is--wide">
                <a href="{url controller=account action=profile}" title="{s name='AccountLinkChangeProfile'}Rechnungsadresse ändern{/s}" class="btn is--small">
                    {s name='AccountLinkChangeProfile'}Rechnungsadresse ändern{/s}
                </a>
            </div>
        {/block}
    </div>
{/block}

{* Payment information *}
{block name="frontend_account_index_payment_method"}
    <div class="account--payment account--box panel has--border is--rounded">
        {block name="frontend_account_index_payment_method_headline"}
            <h2 class="panel--title is--underline">{s name="AccountHeaderAnsprechpartner"}Ansprechpartner{/s}</h2>
        {/block}
        {block name="frontend_account_index_payment_method_content"}
            <div class="getse--panel--body is--wide">
                <div class="getse--panel--body-div1">                    
                    <p>{s name="getsenehmen"}Nehmen Sie als Geschäftskunden Premium Mitglied direkt mit Ihrem Ansprechpartner Kontakt auf.{/s}</p>
                </div>
                <div class="getse--panel--body-div2">
                    <div class="getse-pbd2-left">
                        <p class="getse-pbd2-left1">Jan Gerdhaus</p>
                        <p class="getse-pbd2-left2">(Head of Sales)</p>
                        <p class="getse-pbd2-left3">{s name="getseleftemail"}alex.zimmermann@it-nerd24.de{/s}</p>
                        <p class="getse-pbd2-left4">{s name="getseleftphone"}+(49) 251-203 18251{/s}</p>
                    </div>
                    <div class="getse-pbd2-right">
                        <img src="https://it-nerd24.de/media/image/40/d8/64/Optimization-Featured.png" alt="">
                    </div>
                </div>                
            </div>
        {/block}
    </div>
{/block}

{block name="frontend_account_index_addresses"}
    {if {$B2bStatus} eq 'nostatus'}
        <div class="getse--nost-bronze-silv-cont">
            <p>{s name="getsemehrvortiele"}Mehr Vorteile als Premium-Mitglied{/s}</p>
            <div class="getse--nost-bronze-silv">
                <div class="getse--nost-bronze-silv-l">
                    <span>{s name="getsefastgesch"}Fast geschafft, werden Sie Bronze Member, für mehr Vorteile{/s}</span>
                </div>
                <div class="getse--nost-bronze-silv-c">
                    <div class="getse--nost-bg" style="background: #EA9260; width: {$procent}%"></div>
                </div>
                <div class="getse--nost-bronze-silv-r">
                    <img src="{media path="media/vector/it-nerd24_member_bronze.svg"}" alt="">
                </div>
            </div>
        </div>
    {elseif {$B2bStatus} eq 'bronze'}
        <div class="getse--nost-bronze-silv-cont">
            <p>{s name="getsemehrvortiele"}Mehr Vorteile als Premium-Mitglied{/s}</p>
            <div class="getse--nost-bronze-silv">
                <div class="getse--nost-bronze-silv-l">
                    <span>{s name="getsefastgeschsil"}Fast geschafft, werden Sie Silver Member, für mehr Vorteile{/s}</span>
                </div>
                <div class="getse--nost-bronze-silv-c">
                    <div class="getse--nost-bg" style="background: #EFEFEF; width: {$procent}%"></div>
                </div>
                <div class="getse--nost-bronze-silv-r">
                    <img src="{media path="media/vector/it-nerd24_member_silver.svg"}" alt="">
                </div>
            </div>
        </div>
    {elseif {$B2bStatus} eq 'silver'}
        <div class="getse--nost-bronze-silv-cont">
            <p>{s name="getsemehrvortiele"}Mehr Vorteile als Premium-Mitglied{/s}</p>
            <div class="getse--nost-bronze-silv">
                <div class="getse--nost-bronze-silv-l">
                    <span>{s name="getsefastgeschgold"}Fast geschafft, werden Sie Gold Member, für mehr Vorteile{/s}</span>
                </div>
                <div class="getse--nost-bronze-silv-c">
                    <div class="getse--nost-bg" style="background: #EAB849; width: {$procent}%"></div>
                </div>
                <div class="getse--nost-bronze-silv-r">
                    <img src="{media path="media/vector/it-nerd24_member_gold.svg"}" alt="">
                </div>
            </div>
        </div>
    {else}
    {/if}
    <div class="forms--text forms--text-gets forms--text-getse">
        <p class="callback--ihre">{s name="getsekontfg"}Kontaktformular für Geschäftskunden{/s}</p>
    </div>
    <div class="forms--content content right">
        <div class="form--container-24">
            <div class="getse--forms-container forms--container panel has--border is--rounded"> 
            <div class="panel--title is--underline">{s name="getseformgetsn"}Geschäftskunden{/s}</div> 
            <div class="panel--body"> 
            <form id="support" name="support" class="" method="post" action="https://it-nerd24.de/forms/index/id/23" enctype="multipart/form-data"> 
            <input type="hidden" name="forceMail" value="0"> 
            <div class="forms--inner-form panel--body"> 
            <div> 
            <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="firma" placeholder="Firma*" name="firma">
            </div>
            <div> 
            <input type="text" class="normal " value="" id="ansprechpartner" placeholder="{s name='getseformplanser'}Ansprechpartner{/s}" name="ansprechpartner"> 
            </div> 
            <div> 
            <input type="text" class="normal " value="" id="strasse" placeholder="{s name='getseformplstr'}Straße / Hausnummer{/s}" name="strasse"> 
            </div> 
            <div> 
            <input type="text" class="plz " value="" placeholder="{s name='getseformplPLZ'}PLZ{/s} " id="plz;ort" name="plz"> 
            <input type="text" class="ort " value="" placeholder=" {s name='getseformplOrt'}Ort{/s}" id="plz;ort" name="ort"> 
            </div> 
            <div> 
            <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="tel" placeholder="{s name='getseformpltel'}Telefon*{/s}" name="tel"> 
            </div> 
            <div> 
            <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="email" placeholder="{s name='getseformplemail'}E-Mail Adresse*{/s}" name="email"> 
            </div> 
            <div class="textarea"> 
            <textarea class="normal " id="kommentar" placeholder="{s name='getseformplNachricht'}Nachricht{/s}" name="kommentar"></textarea> 
            </div> 
            <div class="forms--captcha"> 
            <div class="captcha--placeholder" data-src="/widgets/Captcha"></div> 
            </div> 
            <div class="forms--required">{s name='getseformpldiedat'}Die Datenschutzbestimmungen habe ich zur Kenntnis genommen.{/s}</div> 
            <p class="privacy-information"> 
            <input name="privacy-checkbox" type="checkbox" id="privacy-checkbox" required="required" aria-required="true" value="1" class="is--required"> 
            <label for="privacy-checkbox"> {s name='getseformichhab'}Ich habe die{/s} 
            <a title="{s name='getseformDatenschutzbestimmungen'}Datenschutzbestimmungen{/s}" href="https://it-nerd24.de/custom/index/sCustom/2" target="_blank">{s name='getseformDatenschutzbestimmungen'}Datenschutzbestimmungen{/s} </a>
              {s name='getseformzurkenn'}zur Kenntnis genommen.{/s} 
             </label> 
             </p> 
             <div class="buttons">  
             <button class="btn is--primary is--icon-right" type="submit" name="Submit" value="submit">{s name='getseformsenden'}Senden{/s} 
             <i class="icon--arrow-right"></i>
             </button> 
             </div> 
             </div>              
             </form> 
             <span class="getse--form-ast">{s name='getseformsenformhierbei'}* hierbei handelt es sich um ein Pflichtfeld{/s}</span>
             </div> 
            </div>
        </div>
    </div>
    
{/block}


 {* Last seen products *}
 {block name='frontend_index_left_last_articles'}        
    <div class="getse--last">
        <img src="https://it-nerd24.de/media/image/a7/4b/84/helloquence-61189-unsplash.jpg" alt="">
        <div class="getse--last-div">
        <p class="getse--last-div-p1">{s name='getselastattrakt'}Attraktive Angebote für Firmen & Gewerbetreibende{/s}</p>
        <p class="getse--last-div-p2">{s name='getselastlast'}Alle Infos zum B2B Bereich finden Sie hier{/s}</p>
        <a href="/geschaeftskunden" class="getse--last-div-btn btn is--secondary">{s name='getselastzumg'}Zum Geschäftskunden Bereich{/s}</a>
        </div>
    </div>    
{/block}











