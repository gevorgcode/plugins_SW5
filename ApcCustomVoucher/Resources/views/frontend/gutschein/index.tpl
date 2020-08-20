{extends file='parent:frontend/index/index.tpl'}

{namespace name="frontend/gutschein"}

{block name='frontend_index_content_main'}
    <div class="lic--gutshein-top-back">
        <div class="lic--gutshein-top">
            <div class="lic--gutshein-top-l">
                <img src="{media path="media/vector/GiftCard.svg"}" alt="">
            </div>
            <div class="lic--gutshein-top-r">
                {s name="gutscheineinl1455"}Gutscheine <br> einlösen{/s}
            </div>
            <div class="lic--gutschein-top-l-bg"></div>
        </div>
        <div class="lic--gutshein-top-bg"></div>
    </div>
    <div class="lic--gutshein-bott container">
        <p class="soft-code-h3">{s name="gutscheint1"}Im Einzelhandel erworbene Software-Codes können Sie hier einlösen.{/s}</p>
        <p class="soft-code-form-text">{s name="gutscheint2"}Hier können Sie Ihren 12-stelligen Software-Code eingeben.{/s}</p>
        <form id="software-code-form" class="software-code-form" action="/Softwarecode/" method="post" name="software-code">           
            <div>
                <input required style="margin-bottom: 20px;" type="text" name="software-code-value" placeholder='{s name="gutscheintSoftCode"}Software-code{/s}*' /> 
            </div>                       
            <div>
                <input required style="width: 100%; margin-bottom: 20px;" type="email" name="software-code-email" placeholder='{s name="gutscheint3"}Ihre E-Mail{/s}*' />
            </div>
            <div class="input--checkbox-div">    
                <input type="checkbox" name="software-code_checkbox" checked="checked" />
                <span class="input--state checkbox--state">&nbsp;</span>
                <span>{s name="gutscheint4"}Lizenzschlüssel an meine E-Mail senden{/s}</span>
            </div>
            <div class="buttons"><button class="btn is--primary" type="submit">{s name="gutscheint5"}Code einlösen{/s}</button></div>
        </form>
        <p class="software-code-text-h3">{s name="gutscheint6"}So einfach geht’s{/s}</p>
        <p class="software-code-text-p1">{s name="gutscheint7"}Die Software-Codes können Sie bequem in teilnehmenden REWE-Märkten erwerben. Rubbeln Sie den 12-stelligen Software-Code auf der Rückseite der Karte frei. Tragen Sie diesen in das obenstehende Feld ein.{/s}</p>
        <p class="software-code-text-p2">{s name="gutscheint8"}Sobald Sie den Code eingelöst haben, können Sie Ihre Software herunterladen und Sie erhalten Ihren Produktschlüssel. Optional können Sie daraufhin Ihre E-Mail-Adresse angeben und alle Informationen werden Ihnen noch einmal zugesendet.{/s}</p>
    </div>  
{/block}