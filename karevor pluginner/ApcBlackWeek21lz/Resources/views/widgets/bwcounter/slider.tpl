{namespace name="ApcBlackWeek21/index"}

{if {$smarty.now} > 1637708399 && {$smarty.now} < 1638313199}
    <div class="banner-slider--item image-slider--item banner-slider--item-bw21" data-coverimage="true"
        data-containerselector=".banner-slider--banner" data-width="768" data-height="768">
        <div class="banner-slider--item-bw21-l"></div>
        <div class="banner-slider--item-bw21-l-img">
            <div><img src="/custom/plugins/ApcBlackWeek21lz/Resources/images/LizenzguruSliderDesktop.svg" alt=""></div>
        </div>
        <div class="banner-slider--banner" style="width: 239px; height: 239px;">
            <img src="/custom/plugins/ApcBlackWeek21lz/Resources/images/Windows-10.png"
                class="banner-slider--image"                                   
                alt="">
            <div class="banner-content banner-content--bw21">
                <div class="blw21-slider-txt1">{s name='txt9'}Jeden Tag ein neuer <br> Rabatt auf alles,{/s}</div>                                       
                <div class="blw21-slider-txt2">{s name='txt10'}nur solange der <br> Countdown läuft!{/s}</div> 
            </div>            
        </div>
    </div>
{/if}    