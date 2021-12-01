{namespace name="ApcBlackWeek21/index"}

{if {$smarty.now} > 1637708399 && {$smarty.now} < 1638313199}
    <div class="banner-slider--item image-slider--item image-slider--item-bw21" data-coverimage="true" data-containerselector=".banner-slider--banner" data-width="1000" data-height="400">
        <div class="banner-slider--banner" style="width: 100%; ">
            <div class="gen-custom-banner-slider"  >
                <div class="indextop--container">
                    <div class="indextop--cont-left">
                        <div class="banner-content banner-content--bw21">
                            <div class="blw21-slider-txt1">{s name='txt9'}Jeden Tag ein neuer Rabatt auf alles,{/s}</div>                                       
                            <div class="blw21-slider-txt2">{s name='txt10'}nur solange der Countdown läuft!{/s}</div> 
                        </div>    
                        <div class="bw21slider--img-cont">
                            <img src="/custom/plugins/ApcBlackWeek21ln/Resources/images/LicenseNowSliderMobile.svg" alt="">
                        </div>                     
                    </div>
                </div>
            </div>
        </div>
    </div>
    {include file="frontend/index/bwslider_css.tpl"}
{/if}