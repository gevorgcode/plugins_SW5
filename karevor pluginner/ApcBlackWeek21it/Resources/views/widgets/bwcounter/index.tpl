{namespace name="ApcBlackWeek21/index"}

{if {$smarty.now} > 1637708399 && {$smarty.now} < 1638313199}
    {$rabatt = 20}
    {if {$smarty.now} > 1637708399 && {$smarty.now} < 1637794799} <!-- 24 - 20% --> 
        {$rabatt = 20}
    {elseif {$smarty.now} > 1637794799 && {$smarty.now} < 1637881199} <!-- 25 - 25% --> 
        {$rabatt = 25}
    {elseif {$smarty.now} > 1637881199 && {$smarty.now} < 1637967599} <!-- 26 - 40% --> 
        {$rabatt = 40}
    {elseif {$smarty.now} > 1637967599 && {$smarty.now} < 1638140399} <!-- 27,28 - 35% --> 
        {$rabatt = 35}
    {elseif {$smarty.now} > 1638140399 && {$smarty.now} < 1638226799} <!-- 29 - 30% --> 
        {$rabatt = 30}
    {elseif {$smarty.now} > 1638226799 && {$smarty.now} < 1638313199} <!-- 30 - 25% --> 
        {$rabatt = 25}
    {/if}
    <div class="black--week21-banner">
        <div class="black--week21-content">
            <div class="black--week21-counter-cont-img">
                <img class="black--week21-counter-img-desc ic" data-srcset="/custom/plugins/ApcBlackWeek21it/Resources/images/BannerDesktop.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">                    
            </div>
            <div class="black--week21-counter-cont-txt">
                <div class="black--week21-counter-cont-txt1">
                    {s name='txt1'}Der Countdown läuft{/s},
                </div>
                <div class="black--week21-counter-cont-txt2">
                    {s name='txt2'}jetzt Rabatt sichern!{/s}
                </div>
            </div>
            <div class="black--week21-counter-cont-counter">
                <img class="black--week21-counter-img-mob ic" data-srcset="/custom/plugins/ApcBlackWeek21it/Resources/images/BannerMobile.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="">
                <div id="bw21--counter" class="black--week21-counter-cont-counter-numbers">
                    <div id="bw21--hour" class="black--week21-counter-hour"></div>
                    <div id="bw21--minute" class="black--week21-counter-minute"></div>
                    <div id="bw21--secunde" class="black--week21-counter-secunde"></div>
                </div>
                <div class="black--week21-counter-cont-counter-undernumber">
                    <div class="black--week21-counter-hour-txt">{s name='txt3'}Stunden{/s}</div>
                    <div class="black--week21-counter-minute-txt">{s name='txt4'}Minuten{/s}</div>
                    <div class="black--week21-counter-secunde-txt">{s name='txt5'}Sekunden{/s}</div>
                </div>
            </div>
            <div class="black--week21-counter-cont-counter-after"></div>
            <div class="black--week21-counter-cont-txt1-mob">
                {s name='txt1'}Der Countdown läuft{/s},
            </div>
            <div class="black--week21-rabatt-l">
                <div class="black--week21-rabatt-l-t"><span class="black--week21-rabatt-val">{$rabatt}</span>%</div>
                <div class="black--week21-rabatt-l-b">{s name='txt6'}Rabatt sichern!{/s}</div>
            </div>
            <div class="black--week21-rabatt-r">
                {s name='txt7'}Geben Sie{/s} <span>"BIGDEAL24"</span> {s name='txt8'}im <br> Bestellprozess ein, um sich <br> Ihren Rabatt zu sichern.{/s}
            </div>
        </div>                    
        <div class="black--week21-close">
            <i class="icon--cross"></i>
        </div>
        {include file="frontend/index/counter_js.tpl"}
        {include file="frontend/index/counter_css.tpl"}
    </div>
{/if}    