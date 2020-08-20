{extends file='parent:frontend/forms/index.tpl'}

{namespace name="ApsB2b/frontend"}

{block name="frontend_index_header"}
    {$smarty.block.parent}
    {if {$sSupport.id} eq '23'}
        <div class="lic--b2b-gesch-banner">
            <div class="lic--b2b-gesch-banner-cont">
                <div class="lic--b2b-gesch-banner-images">
                    <div class="lic--indexlicense--svg-div">
                        <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Windows.svg"}" alt="">
                        <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt1 namespace='frontend/genBannerSlider'}Windows <br> Betriebssysteme{/s}</div>
                    </div>
                    <div class="lic--indexlicense--svg-div">
                        <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Office.svg"}" alt="">
                        <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt2 namespace='frontend/genBannerSlider'}Microsoft Office <br> Pakete & Produkte{/s}</div>
                    </div>
                    <div class="lic--indexlicense--svg-div">
                        <img class="lic--indexlicense--svg" src="{media path="media/vector/Server.svg"}" alt="">
                        <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt3 namespace='frontend/genBannerSlider'}Windows <br> Server{/s}</div>
                    </div>
                    <div class="lic--indexlicense--svg-div">
                        <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Autodesk.svg"}" alt="">
                        <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt4 namespace='frontend/genBannerSlider'}Autodesk{/s}</div>
                    </div>
                </div>
                <div class="lic--b2b-gesch-banner-txt">
                    {s name=licFormGeshTitle namespace='frontend/genBannerSlider'}Lizenzen für <br> Geschäftskunden{/s}
                </div>
            </div>
        </div>
    {/if}
{/block}

{* Forms headline *}
{block name='frontend_forms_index_headline'}
    {if {$sSupport.id} eq '23'}
        {if $sSupport.sElements}
                    
        {elseif $sSupport.text2}
            <div class="form--23-succes">
                {include file="frontend/_includes/messages.tpl" type="success" content=$sSupport.text2}
            </div>
        {/if}   
    {else}
        {$smarty.block.parent}
    {/if}
{/block}


{* Forms Content *}
{block name='frontend_forms_index_content'}
    {if {$sSupport.id} eq '23'}
    <div class="forms--text forms--text-gets" style="display: none;">{$sSupport.text}</div>
        <div class="form--container-24">
        <div class="lic--form-gesh-form-cont">
            {if $sSupport.text2}
                <div class="forms--container panel form--success"></div>
            {/if}
            {$smarty.block.parent}       
            <div class="lic--b2b-gesch-banner-mob">
                <div class="lic--b2b-gesch-banner-cont">
                    <div class="lic--b2b-gesch-banner-images">
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Windows.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt1 namespace='frontend/genBannerSlider'}Windows <br> Betriebssysteme{/s}</div>
                        </div>
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Office.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt2 namespace='frontend/genBannerSlider'}Microsoft Office <br> Pakete & Produkte{/s}</div>
                        </div>
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Server.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt3 namespace='frontend/genBannerSlider'}Windows <br> Server{/s}</div>
                        </div>
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Autodesk.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt4 namespace='frontend/genBannerSlider'}Autodesk{/s}</div>
                        </div>
                    </div>
                    <div class="lic--b2b-gesch-banner-txt">
                        {s name=licFormGeshTitle namespace='frontend/genBannerSlider'}Lizenzen für <br> Geschäftskunden{/s}
                    </div>
                </div>
            </div>
            <div class="lic--form-gesh-form-r">
                <img src="{media path="media/vector/LogorpZvqrUPdlayf.svg"}" alt="" class="lic--form-gesh-form-r-img">
                <div class="lic--form-gesh-form-r-txt1">
                    {s name='indexlicenseFormrtxt1'}Kontaktieren Sie uns{/s}
                </div>
                <div class="lic--form-gesh-form-r-txt2">
                    {s name='indexlicenseFormrtxt2'}Brauchen Sie ein Angebot oder haben Sie Fragen zu unseren Artikel?{/s}
                </div>
                <div class="lic--form-gesh-form-r-txt3">
                    {s name='indexlicenseFormrtxt3'}Wir antworten Ihnen innerhalb der nächsten 24 Stunden und stellen Ihnen für Ihr Anliegen eine Ansprechperson zur Verfügung.{/s}
                </div>
                <div class="lic--form-gesh-form-r-txt4">
                    {s name='indexlicenseFormrtxt4'}Haben Sie Anfrage für bestimmte Artikel? <br> - Legen Sie dazu einfach die Produkte in Ihrem Warenkorb und geben Sie ein Angebot für Geschäftskunden in Autfrag.{/s}
                </div>
            </div>
        </div>        
    </div>
    {else}
    {$smarty.block.parent}
    {/if}
{/block}


{* Footer *}
{block name="frontend_index_footer"}
    {if {$sSupport.id} eq '23'}
        <div class="form--24-contents">
            <div class="emotion--wrapper is--fullscreen" data-controllerurl="/widgets/emotion/index/emotionId/289/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
            <div class="lic-f24-em2">
                <div class="emotion--wrapper" data-controllerurl="/widgets/emotion/index/emotionId/271/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
            </div>
            <div class="lic-f24-ansprechpersone">
                <p class="unser--unser">{s name='getsForTeamLic'}Ihre Ansprechpersonen in unserem team{/s}</p>
                <div class="gets--team-cont">
                    <div class="gets--team">
                        <img class="gets--team-img" src="{media path="media/image/Alex.png"}" alt="">
                        <p class="gets--team-p1">Alex Zimmermann</p>
                        <div class="gets-team-email-cont">
                            <a href="mailto:zimmermann@license-now.de" class="gets-team-email">zimmermann@license-now.de</a>
                        </div>   
                        <p class="gets-team-pash">{s name='getsForchief'}Chief Sales Officer{/s}</p>
                        <p style="text-align: left">{s name='getsForteit'}IT-Produkte, Software und Lizenzierungen sind ein zunehmend komplexes Thema. Die fachkundige Beratung zur Lizenzierung von den bei uns angebotenen Produkten ist das Fachgebiet von Alex Zimmermann.{/s}</p>
                    </div>
                    <div class="gets--team">
                        <img class="gets--team-img" src="{media path="media/image/Jan.png"}" alt="">
                        <p class="gets--team-p1">Alfredo Sanchez</p>
                        <div class="gets-team-email-cont">
                            <a href="mailto:sanchez@license-now.de" class="gets-team-email">sanchez@license-now.de</a>
                        </div>    
                        <p class="gets-team-pash">{s name='getsFortehead'}Head of Sales{/s}</p>
                        <p style="text-align: left">{s name='getsFortedierich'}Die richtige Lizenzierung, das Lizenzmanagement, sowie die reibungslose Abwicklung von Kooperationsvereinbarungen - als Head of Sales ist Alfredo Sanchez bei uns für alles verantwortlich, was Kooperationsverträge betrifft.{/s}</p>
                    </div>
                    <div class="gets--team">
                        <img class="gets--team-img" src="{media path="media/image/Johanna.png"}" alt="">
                        <p class="gets--team-p1">Katrin Ebert</p>
                        <div class="gets-team-email-cont">
                            <a href="mailto:ebert@license-now.de" class="gets-team-email">ebert@license-now.de</a>
                        </div>   
                        <p class="gets-team-pash">{s name='getsForTeamKey'}Key Account Manager{/s}</p>
                        <p style="text-align: left">{s name='getsForTeamHerr'}Frau Ebert ist bei License-Now für alles rund um das Thema Großkundenbetreuung zuständig. Er kennt die Wünsche und Bedürfnisse unserer Klienten und entwickelt gemeinsam mit Ihnen die richtige Vision für eine gelungene Zusammenarbeit.{/s}</p>
                    </div>
                </div>
            </div>
            <div class="lic-f24-em3">
                <div class="emotion--wrapper" data-controllerurl="/widgets/emotion/index/emotionId/276/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
            </div>
        </div>
    {/if}
    {$smarty.block.parent}
{/block}