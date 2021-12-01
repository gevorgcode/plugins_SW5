{namespace name="ApcXmas21/index"}

{if {$xmas21}}
    <div class="banner-slider--item image-slider--item image-slider--item1 banner-slider--item-xmas21-slider-mob" data-coverimage="true" data-containerselector=".banner-slider--banner" data-width="1000" data-height="400">
        <div class="banner-slider--banner" style="width: 100%; ">
            <div class="gen-custom-banner-slider gen-custom-banner-slider--black--week-mob new--office--slider-mob" style="   height: 600px;">
                <div class="xmas21-slider-content-mob">
                    <div class="xmas21--mob-1">
                        <img data-srcset="/custom/plugins/ApcXmas21it/Resources/images/OrnamentsMobile.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="ic">
                    </div>
                    <div class="xmas21--mob-2">
                        {$xmas21.percentValue}%
                    </div>
                    <div class="xmas21--mob-3">
                        <div class="xmas21-slider-contr-artName-t">{$xmas21.articleName1}</div>
                        <div class="xmas21-slider-contr-artName-b">{$xmas21.articleName2}</div>
                    </div>
                    <div class="xmas21--mob-4" id="xmas21--copy--mob" data-copy="{$xmas21.code}">
                        <img data-srcset="/custom/plugins/ApcXmas21it/Resources/images/Door.png" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="ic">
                        <div class="xmas21-slider-contl-month-mob">
                                {$xmas21.day}. {s name='Xmastxt1'}Dezember{/s}
                            </div>
                            <div id="xmas21--code--mob" class="xmas21-slider-contl-code-mob">
                                {$xmas21.code}
                            </div>
                            <div id="xmas21--copy-copied--mob" class="xmas21-slider-contl-code-copy-mob">
                                copied
                            </div>
                    </div>
                    <a class="xmas21--mob-5" href="{if {$xmas21.sArticle}}{url controller=detail action=index sArticle={$xmas21.sArticle}}{else}{url controller=index}{$xmas21.url}{/if}"> 
                        {s namespace=frontend/index/index name=slideBudil4}Jetzt hier kaufen{/s}
                    </a>
                </div>    
                <div class="gen-custom-banner-slider--xmas21-snow-mob"></div>
            </div>
        </div>
    </div>           
{/if}