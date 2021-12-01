{namespace name="ApcXmas21/index"}

{if {$xmas21}}
    <div class="banner-slider--item image-slider--item banner-slider--item-xmas21-slider-desc" data-coverimage="true" data-containerselector=".banner-slider--banner" data-width="1000" data-height="400">
        <div class="banner-slider--banner" style="width: 100%; ">
            <div class="gen-custom-banner-slider gen-custom-banner-slider--xmas21 gen-custom-banner-slider--black--week gen--budilnik">            
                <div class="bl-w-cont">                                   
                    <div class="xmas21-slider-content bud--content">
                        <div class="xmas21-slider-contl" id="xmas21--copy" data-copy="{$xmas21.code}">
                            <img data-srcset="/custom/plugins/ApcXmas21it/Resources/images/Door.png" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="ic">
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
                        <div class="xmas21-slider-contc">
                            <div class="xmas21-slider-contc-imgl">
                                <img data-srcset="/custom/plugins/ApcXmas21it/Resources/images/OrnamentsDesktop.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="ic">
                            </div>   
                            <div class="xmas21-slider-contc-imgr">
                                <a href="{if {$xmas21.sArticle}}{url controller=detail action=index sArticle={$xmas21.sArticle}}{else}{url controller=index}{$xmas21.url}{/if}"> 
                                    <img data-srcset="{if $xmas21.img != x}/custom/plugins/ApcXmas21it/Resources/images/Products/{$xmas21.img}{else}{link file='frontend/_public/src/img/no-picture.jpg'}{/if}" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="" class="ic">
                                </a>
                            </div>   
                        </div>                                        
                        <div class="xmas21-slider-contr">
                            <div class="xmas21-slider-contr-discount">
                                {$xmas21.percentValue}%
                            </div>  
                            <div class="xmas21-slider-contr-artName">
                                <div class="xmas21-slider-contr-artName-t">{$xmas21.articleName1}</div>
                                <div class="xmas21-slider-contr-artName-b">{$xmas21.articleName2}</div>
                            </div>  
                        </div>                                        
                    </div>                                    
                </div>
                <div class="gen-custom-banner-slider--xmas21-snow"></div>
            </div>
        </div>
    </div> 
{/if}

