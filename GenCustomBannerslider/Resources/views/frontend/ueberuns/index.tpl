{extends file='parent:frontend/index/index.tpl'}

{namespace name="frontend/genBannerSlider"}

{block name="frontend_index_header"}
    {$smarty.block.parent}
    <div class="lic--ueber-uns-top">
        <div class="lic--indexlicense-container ueberuns">
            <div class="lic--ueber-uns-toptb">
                 <div class="lic--ueber-uns-topt">
                    <p class="lic-indexlicense-text3">{s name=indexlicenset3} <span>Wachsen,</span> <span>Lernen,</span> <span>Erweitern</span>{/s}</p>
                </div>
                <div class="lic--ueber-uns-topb">                                 
                    <div class="lic--indexlicense--svgs">
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Windows.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt1}Windows <br> Betriebssysteme{/s}</div>
                        </div>
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Office.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt2}Microsoft Office <br> Pakete & Produkte{/s}</div>
                        </div>
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Server.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt3}Windows <br> Server{/s}</div>
                        </div>
                        <div class="lic--indexlicense--svg-div">
                            <img class="lic--indexlicense--svg" src="{media path="media/vector/Product-Autodesk.svg"}" alt="">
                            <div class="lic--indexlicense--svg-text">{s name=indexlicensesvgt4}Autodesk{/s}</div>
                        </div>
                    </div>
                    <div class="lic--ueber-uns-txt">
                        <p class="lic-indexlicense-text1">{s name=indexlicenset1}Jetzt noch schneller & sicherer{/s}</p>
                        <p class="lic-indexlicense-text2">{s name=indexlicenset2}Wir bieten allen Kunden den bestmöglichen und schnellsten Service und gestalten Softwarekauf so einfach wie möglich.{/s}</p>
                    </div>   
                </div>                
            </div>   
        </div>
    </div>
{/block}

{block name='frontend_index_content'}
    <div class="lic--ueber-uns-cont">
        <div class="lic--ueber-uns-lauft-mob">
            <div class="emotion--wrapper is--fullscreen" data-controllerurl="/widgets/emotion/index/emotionId/292/controllerName/index" data-availabledevices="3,4" style="display: block;"></div>
            <div class="lic--ueber-uns-lauft-mob-undem">
                <img class="lic--ueber-uns-lauftr-img-mob" src="{media path="media/image/U-EURber-uns.png"}" alt="">
                <div class="ueber--solauft">
                    <div class="so--lauft">
                        <div class="so--lauft-img">
                            <img src="{media path="media/vector/Buy.svg"}" alt="">
                        </div>            
                        <div class="so--lauft-text">
                            {s name=solauftsTxt1 namespace="frontend/genBannerSlider/solaufts"}Online <br>
                            schnell & sicher <br>
                            einkaufen{/s}
                        </div>
                    </div>
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/Instant-Mail.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt2 namespace="frontend/genBannerSlider/solaufts"}Sofort Anleitung, <br>
                            Download Link & <br>
                            Produktschlüssel <br>
                            erhalten{/s}
                        </div>
                    </div>   
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/Quality.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt5 namespace="frontend/genBannerSlider/solaufts"}Qualität zu<br>
                            guten Preisen{/s}
                        </div>
                    </div>   
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/Money-Back.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt6 namespace="frontend/genBannerSlider/solaufts"}Zufrieden oder <br> 
                            Geld zurück{/s}
                        </div>
                    </div>
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/New-Offers.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt7 namespace="frontend/genBannerSlider/solaufts"}Immer wieder <br>
                             neue Angebote{/s}
                        </div>
                    </div>
                </div>
                <div class="lic--ueber-uns-lauftr-txts">                    
                    <p>{s name=ueberUnderImageTxt1 namespace="frontend/genBannerSlider/ueberuns"}Unser Unternehmen – Spezialist für günstige Software Licese-now ist ein deutsches Start-up mit Sitz in Berlin. Mittlerweile sind wir seit vier Jahren auf dem Markt und bieten unseren Kunden einen optimalen Service für den Kauf günstiger Software an. Dabei entwickeln wir uns ständig weiter, um trotz der schnellen Veränderungen im IT-Bereich stets auf dem aktuellen Stand zu bleiben. Das stellt eine der wesentlichen Voraussetzungen dafür dar, um unseren Kunden ein herausragendes Einkaufserlebnis zu bieten. Unsere Software-Produkte sind nicht nur ausgesprochen preiswert, sondern auch schnell und sicher. Daher stellt license-now eine hervorragende Option für den Kauf von Softwarelizenzen dar.{/s}</p>
                    <p>{s name=ueberUnderImageTxt2 namespace="frontend/genBannerSlider/ueberuns"}Ein zeitgemäßes Angebot für den Softwarekauf{/s}</p>
                    <p>{s name=ueberUnderImageTxt3 namespace="frontend/genBannerSlider/ueberuns"}Die traditionelle Form, Software zu kaufen, erscheint uns bei license-now nicht mehr zeitgemäß. Wenn Sie zunächst in ein Fachgeschäft in Ihrer Umgebung fahren müssen, um dort eine DVD zu erwerben, verlieren Sie viel Zeit. Außerdem fallen Fahrtkosten an. Aufgrund der Kosten für die Verkaufsräume, für die physischen Datenträger und für das erforderliche Lager sind die Produkte hier außerdem sehr teuer. Die Auswahl ist hingegen stark eingegrenzt. Der klassische Online-Handel kann zwar einige dieser Probleme beheben. Wenn hierbei jedoch physische Datenträger zum Einsatz kommen, müssen Sie lange auf die Produkte warten und außerdem entstehen dadurch zusätzliche Kosten.{/s}</p>
                    <p>{s name=ueberUnderImageTxt4 namespace="frontend/genBannerSlider/ueberuns"}Bei license-now haben wir daher ein zeitgemäßes Konzept für den Software-Kauf entwickelt. In unserem Shop stehen alle Produkte zum Download bereit. Wenn Sie ein Programm kaufen, können sie es daher unmittelbar nutzen. Direkt nach dem Kauf senden wir Ihnen den Lizenzschlüssel, den Sie für die Aktivierung benötigen, per E-Mail zu. Das spart Zeit und Kosten. Es kommt hinzu, dass die Rechnerarchitekturen immer komplexer und individueller werden. Bei der Installation einer Software auf einem Firmenserver kommt es daher immer häufiger zu Problemen. Bei den klassischen Vertriebswegen ist der Support jedoch kostenpflichtig. Das führt zu erheblichen weiteren Kosten. Bei license-now unterstützen wir Sie auch bei der Installation und der Konfiguration der Software. Dafür fallen keine zusätzlichen Kosten an.{/s}</p>
                    <p>{s name=ueberUnderImageTxt5 namespace="frontend/genBannerSlider/ueberuns"}Die Gründe für unsere preiswerten Angebote{/s}</p>
                    <p>{s name=ueberUnderImageTxt6 namespace="frontend/genBannerSlider/ueberuns"}Neben den bereits beschriebenen effizienten internen Strukturen gibt es noch einen weiteren Grund dafür, dass wir Ihnen bei license-now Softwarelizenzen zum Bestpreis anbieten können. Unsere Einkaufsstrategie besteht darin, überzählige Produktschlüssel bei anderen Distributoren aufzukaufen. Durch hohe Stückzahlen erzielen wir dabei besonders günstige Preise. Die Lizenzschlüssel wurden jedoch noch nie zuvor verwendet.{/s}</p>
                </div>
            </div>
        </div>
        <div class="lic--ueber-uns-lauft">
            <div class="lic--ueber-uns-lauftl">
                <img class="lic--ueber-uns-lauftl-img" src="{media path="media/vector/LogorpZvqrUPdlayf.svg"}" alt="">
                <div class="ueber--solauft">
                    <div class="so--lauft">
                        <div class="so--lauft-img">
                            <img src="{media path="media/vector/Buy.svg"}" alt="">
                        </div>            
                        <div class="so--lauft-text">
                            {s name=solauftsTxt1 namespace="frontend/genBannerSlider/solaufts"}Online <br>
                            schnell & sicher <br>
                            einkaufen{/s}
                        </div>
                    </div>
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/Instant-Mail.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt2 namespace="frontend/genBannerSlider/solaufts"}Sofort Anleitung, <br>
                            Download Link & <br>
                            Produktschlüssel <br>
                            erhalten{/s}
                        </div>
                    </div>   
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/Quality.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt5 namespace="frontend/genBannerSlider/solaufts"}Qualität zu<br>
                            guten Preisen{/s}
                        </div>
                    </div>   
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/Money-Back.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt6 namespace="frontend/genBannerSlider/solaufts"}Zufrieden oder <br> 
                            Geld zurück{/s}
                        </div>
                    </div>
                    <div class="so--lauft">
                       <div class="so--lauft-img">
                            <img src="{media path="media/vector/New-Offers.svg"}" alt="">
                        </div>             
                        <div class="so--lauft-text">
                            {s name=solauftsTxt7 namespace="frontend/genBannerSlider/solaufts"}Immer wieder <br>
                             neue Angebote{/s}
                        </div>
                    </div>
                </div>
            </div>
            <div class="lic--ueber-uns-lauftr">
                <div class="lic--ueber-uns-lauftr-img-c">
                    <img class="lic--ueber-uns-lauftr-img" src="{media path="media/image/U-EURber-uns.png"}" alt="">
                    <p>{s name=ueberimgtext }Schnell und sicher <br> Software{/s}</p>
                </div> 
                <div class="lic--ueber-uns-lauftr-txts">                    
                    <p>{s name=ueberUnderImageTxt1 namespace="frontend/genBannerSlider/ueberuns"}Unser Unternehmen – Spezialist für günstige Software Licese-now ist ein deutsches Start-up mit Sitz in Berlin. Mittlerweile sind wir seit vier Jahren auf dem Markt und bieten unseren Kunden einen optimalen Service für den Kauf günstiger Software an. Dabei entwickeln wir uns ständig weiter, um trotz der schnellen Veränderungen im IT-Bereich stets auf dem aktuellen Stand zu bleiben. Das stellt eine der wesentlichen Voraussetzungen dafür dar, um unseren Kunden ein herausragendes Einkaufserlebnis zu bieten. Unsere Software-Produkte sind nicht nur ausgesprochen preiswert, sondern auch schnell und sicher. Daher stellt license-now eine hervorragende Option für den Kauf von Softwarelizenzen dar.{/s}</p>
                    <p>{s name=ueberUnderImageTxt2 namespace="frontend/genBannerSlider/ueberuns"}Ein zeitgemäßes Angebot für den Softwarekauf{/s}</p>
                    <p>{s name=ueberUnderImageTxt3 namespace="frontend/genBannerSlider/ueberuns"}Die traditionelle Form, Software zu kaufen, erscheint uns bei license-now nicht mehr zeitgemäß. Wenn Sie zunächst in ein Fachgeschäft in Ihrer Umgebung fahren müssen, um dort eine DVD zu erwerben, verlieren Sie viel Zeit. Außerdem fallen Fahrtkosten an. Aufgrund der Kosten für die Verkaufsräume, für die physischen Datenträger und für das erforderliche Lager sind die Produkte hier außerdem sehr teuer. Die Auswahl ist hingegen stark eingegrenzt. Der klassische Online-Handel kann zwar einige dieser Probleme beheben. Wenn hierbei jedoch physische Datenträger zum Einsatz kommen, müssen Sie lange auf die Produkte warten und außerdem entstehen dadurch zusätzliche Kosten.{/s}</p>
                    <p>{s name=ueberUnderImageTxt4 namespace="frontend/genBannerSlider/ueberuns"}Bei license-now haben wir daher ein zeitgemäßes Konzept für den Software-Kauf entwickelt. In unserem Shop stehen alle Produkte zum Download bereit. Wenn Sie ein Programm kaufen, können sie es daher unmittelbar nutzen. Direkt nach dem Kauf senden wir Ihnen den Lizenzschlüssel, den Sie für die Aktivierung benötigen, per E-Mail zu. Das spart Zeit und Kosten. Es kommt hinzu, dass die Rechnerarchitekturen immer komplexer und individueller werden. Bei der Installation einer Software auf einem Firmenserver kommt es daher immer häufiger zu Problemen. Bei den klassischen Vertriebswegen ist der Support jedoch kostenpflichtig. Das führt zu erheblichen weiteren Kosten. Bei license-now unterstützen wir Sie auch bei der Installation und der Konfiguration der Software. Dafür fallen keine zusätzlichen Kosten an.{/s}</p>
                    <p>{s name=ueberUnderImageTxt5 namespace="frontend/genBannerSlider/ueberuns"}Die Gründe für unsere preiswerten Angebote{/s}</p>
                    <p>{s name=ueberUnderImageTxt6 namespace="frontend/genBannerSlider/ueberuns"}Neben den bereits beschriebenen effizienten internen Strukturen gibt es noch einen weiteren Grund dafür, dass wir Ihnen bei license-now Softwarelizenzen zum Bestpreis anbieten können. Unsere Einkaufsstrategie besteht darin, überzählige Produktschlüssel bei anderen Distributoren aufzukaufen. Durch hohe Stückzahlen erzielen wir dabei besonders günstige Preise. Die Lizenzschlüssel wurden jedoch noch nie zuvor verwendet.{/s}</p>
                </div>               
            </div>
        </div>
        <div class="lic--ueber-uns-prod-pack">
            <div class="lic--ueber-uns-prod-packl">
                 <img src="{media path="media/image/Multiple.png"}" alt="">
            </div>
            <div class="lic--ueber-uns-prod-packr">
                <h6>{s name=ueberProdPackTxt1}Wie kommen unsere Angebote zur Stande?{/s}</h6>
                <p>{s name=ueberProdPackTxt2}Wir kaufen bei vielen Distributoren hohe Stückzahlen von neuen ProduktSchlüssel auf, welche nicht verwendet oder installiert wurden. Durch diese Art den Einkaufs, dem Entfall von Liefer-und Lagergebühren aufgrund des virtuellen Lieferweges, können wir derart günstige Preise realisieren und weitergeben.{/s}</p>   
            </div>
        </div>
        <div class="lic--ueber-uns-under-prpack">
            <div class="lic--ueber-uns-under-prpackl">
                <img src="{media path="media/vector/Paragraph.svg"}" alt="">
            </div>
            <div class="lic--ueber-uns-under-prpackr">
                <h6>{s name=ueberUnderPrPackTxt1}Immer wieder wird uns die Frage gestellt, ob das licensenow Geschäftsmodell wirklich legal ist.{/s}</h6>
                <p>{s name=ueberUnderPrPackTxt2}Ist das Geschäftsmodell von license-now legal?{/s}</p>
                <p>{s name=ueberUnderPrPackTxt3}Manche unserer Kunden haben Zweifel, ob das beschriebene Geschäftsmodell wirklich legal ist. Daher stellt dies auch für uns eine wichtige Frage dar, die wir immer wieder anwaltlich prüfen lassen. Die letzte umfassende Überprüfung erfolgte im Jahre 2018.{/s}</p>
                <p>{s name=ueberUnderPrPackTxt4}Dabei hat eine der renommiertesten deutschen Anwaltskanzleien unsere komplette geschäftliche Tätigkeit durchleuchtet und rechtlich überprüft. Im Mittelpunkt des Interesses standen dabei unsere Einkaufsprozesse und die rechtlichen Grundlagen für den Verkauf der Lizenzen. Die Anwälte kamen zu dem Ergebnis, dass unser Geschäftsmodell in urheberrechtlicher Hinsicht bedenkenlos ist. Daher können Sie den Kauf unserer Software-Lizenzen unbesorgt durchführen.{/s}</p>
                <p>{s name=ueberUnderPrPackTxt5}Um Ihnen eine umfassende Sicherheit zu bieten, legen wir auch hohe Maßstäbe an unsere weltweiten Einkaufsquellen an. Hierbei muss es sich um offizielle Distributoren handeln und außerdem überprüfen wir, ob die Produkte für den entsprechenden Wirtschaftsraum freigegeben sind. Daher erhalten Sie die Gewissheit, dass Sie bei license-now nur rechtlich einwandfreie Software kaufen.{/s}</p>
            </div>
        </div>
        <div class="lic--ueber-uns-form-cont forms--content content">                        
            <div class="forms--container panel"> 
                <div class="panel--body"> 
                    <form id="support" name="support" class="" method="post" action="{url controller=forms}/index/id/5" enctype="multipart/form-data"> 
                        <input type="hidden" name="forceMail" value="0"> 
                        <div class="forms--inner-form panel--body">                            
                            <div class="ueber-form-namefirma">
                                <div> 
                                    <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="name" placeholder="Name*" name="name"> 
                                </div>
                                <div> 
                                    <input type="text" class="normal is--required required" required="required" aria-required="true" value="" id="firma" placeholder="Firma*" name="firma">
                                </div>  
                            </div>
                            <div> 
                                <input type="text" class="normal " value="" id="strasse" placeholder="Straße / Hausnummer" name="strasse"> 
                            </div> 
                            <div> 
                                <input type="email" class="normal is--required required" required="required" aria-required="true" value="" id="Email" placeholder="E-Mail Adresse *" name="Email"> 
                            </div> 
                            <div> 
                                <input type="text" class="plz " value="" placeholder="PLZ " id="plz;ort" name="plz"> 
                                <input type="text" class="ort " value="" placeholder=" Ort" id="plz;ort" name="ort"> 
                            </div>                            
                            <div> 
                                <input type="text" class="normal " value="" id="telefon" placeholder="Telefonnumer" name="telefon"> 
                            </div> 
                            <div class="textarea"> 
                                <textarea class="normal " id="Nachricht" placeholder="Ihre Nachricht..." name="Nachricht" style="min-height: 90px;"></textarea> 
                            </div> 
                            <div class="forms--required">Die Datenschutzbestimmungen habe ich zur Kenntnis genommen.</div> 
                            <p class="privacy-information input--checkbox-div"> 
                                <input name="privacy-checkbox" type="checkbox" id="privacy-checkbox" required="required" aria-label="{$snippetPrivacyText|strip_tags|escape}" aria-required="true" value="1" class="is--required"{if $smarty.post['privacy-checkbox']} checked{/if} />
                                <span class="input--state checkbox--state">&nbsp;</span> 
                                <label for="privacy-checkbox">
                                    {s name="PrivacyText" namespace="frontend/index/privacy"}{/s}
                                </label>
                            </p> 
                            <div class="buttons"> 
                                <button class="btn is--primary" type="submit" name="Submit" value="submit">{s namespace="frontend/forms/elements" name='SupportActionSubmit'}Anfrage versenden{/s}</button> 
                            </div> 
                        </div> 
                    </form>
                </div> 
            </div> 
            <div class="form--5-rtext">
                <div class="form--5-rtextt">
                    <h1 class="forms--title">{s name='indexlicenseFormrtxt0' namespace="ApsB2b/frontend"}Kontaktieren Sie uns{/s}</h1>
                    <h2>{s name='indexlicenseFormrtxt2' namespace="ApsB2b/frontend"}Brauchen Sie ein Angebot oder haben Sie Fragen zu unseren Artikel?{/s}</h2>
                    <p>{s name='indexlicenseFormrtxt3' namespace="ApsB2b/frontend"}Wir antworten Ihnen innerhalb der nächsten 24 Stunden und stellen Ihnen für Ihr Anliegen eine Ansprechperson zur Verfügung.{/s}</p>

                </div>
                <div class="form--5-rtextb">
                    <p>{s name='indexlicenseFormrtxt4' namespace="ApsB2b/frontend"}Haben Sie Anfrage für bestimmte Artikel? <br> - Legen Sie dazu einfach die Produkte in Ihrem Warenkorb und geben Sie ein Angebot für Geschäftskunden in Autfrag.{/s}</p>
                </div>   
            </div>     
        </div>        
    </div>
{/block}
           
{* Footer *}
{block name="frontend_index_footer"}    
    <div class="ueber--emotions">
        <div class="lic--ueber-uns-kennat-sl">
            <div class="lic--ueber-uns-kennat-sl-headlinine">
                {s name=ueberKennat}Uns kennt man aus...{/s}                
            </div>
            <div class="lic--ueber-uns-kennat-sl-imgs">
                <img src="{media path="media/image/Download__283.png"}" alt="">
                <img src="{media path="media/image/sterntv-logo.png"}" alt="">
                <img src="{media path="media/image/Billiger-de-logo.png"}" alt="">
                <img src="{media path="media/image/Download__284.png"}" alt="">
                <img src="{media path="media/image/PCWelt-Logo.png"}" alt="">
                <img src="{media path="media/image/Downl.png"}" alt="">
                
                {*}<img src="{media path="media/image/Bild-1-2x1_2_110x110KIGdGZdNGJi6f.png"}" alt="">
                <img src="{media path="media/image/Bild-2-2x1_1_110x110fPTSZ2Vqp8WGP.png"}" alt="">
                <img src="{media path="media/image/Bild-3-2x1_1_110x1109KrGKIBWEvHjw.png"}" alt="">
                <img src="{media path="media/image/Bild-4-2x1_1_110x110AwhrU92mA9GZu.png"}" alt="">
                <img src="{media path="media/image/Bild-5-2x1_1_110x1101YTX7BWPdnchW.png"}" alt="">
                <img src="{media path="media/image/Bild-6-2x1_1_110x110PB2EMdKkGb0Kj.png"}" alt="">{*}
            </div>
        </div>
        <div class="emotion--wrapper is--fullscreen" data-controllerurl="/widgets/emotion/index/emotionId/289/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
        <div class="emotion--wrapper" data-controllerurl="/widgets/emotion/index/emotionId/276/controllerName/index" data-availabledevices="0,1,2,3,4" style="display: block;"></div>
    </div>
    {$smarty.block.parent}
{/block}  

                   
                                                         


