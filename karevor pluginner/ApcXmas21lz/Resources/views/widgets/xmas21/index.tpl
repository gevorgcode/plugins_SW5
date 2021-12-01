{namespace name="ApcXmas21/index"}

{if {$xmas21}}
    <div class="banner-slider--item image-slider--item banner-slider--item-xmas21" data-coverimage="true"
        data-containerselector=".banner-slider--banner" data-width="768" data-height="768">
        <div class="banner-slider--item-xmas21-l"></div>
        <div class="banner-slider--item-xmas21-l-img">
            <div class="banner-slider--item-xmas21-l-img-cont">
                <div class="xmas21--door--zangulak">
                    <img src="/custom/plugins/ApcXmas21lz/Resources/images/OrnamentsDesktop_lz.svg" alt="">
                </div>
                <div class="xmas21--door-cont">
                    <div class="xmas21--door-cont-cont" id="xmas21--copy" data-copy="{$xmas21.code}">
                        <img src="/custom/plugins/ApcXmas21lz/Resources/images/Door_lz.png" alt="">
                        <div class="xmas21-slider-contl-month">
                            {$xmas21.day}. {s name='Xmastxt1'}Dezember{/s}
                        </div>
                        <div id="xmas21--code" class="xmas21-slider-contl-code">
                            {$xmas21.code}
                        </div>
                        <div id="xmas21--copy-copied" class="xmas21-slider-contl-code-copy">
                            copied
                        </div>
                    </div>
                </div>                
            </div>
        </div>
        <div class="banner-slider--banner">
            <img src="{if $xmas21.img != x}/custom/plugins/ApcXmas21lz/Resources/images/Products/{$xmas21.img}{else}{link file='frontend/_public/src/img/no-picture.jpg'}{/if}"
                class="banner-slider--image"                                   
                alt="">
            <div class="banner-content banner-content--xmas21">
                <div class="xmas21-slider-contr-discount">
                    {$xmas21.percentValue}%
                </div>  
                <div class="xmas21-slider-contr-artName">
                    <div class="xmas21-slider-contr-artName-t">{$xmas21.articleName1}</div>
                    <div class="xmas21-slider-contr-artName-b">{$xmas21.articleName2}</div>
                </div>  
                <div class="xmas21-btn--cont">
                    <a class="xmas21-btn" href="{if {$xmas21.sArticle}}{url controller=detail action=index sArticle={$xmas21.sArticle}}{else}{url controller=index}{$xmas21.url}{/if}"> 
                        {s name='LizenzSlideBtn' namespace="frontend/index/index"}Jetzt hier kaufen{/s}
                    </a>
                </div>
            </div>            
        </div>
    </div>
{/if}