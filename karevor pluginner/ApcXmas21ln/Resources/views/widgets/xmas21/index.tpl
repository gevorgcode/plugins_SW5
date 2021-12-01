{namespace name="ApcXmas21/index"}

{if {$xmas21}}
    <div class="banner-slider--item image-slider--item image-slider--item-xmas21" data-coverimage="true" data-containerselector=".banner-slider--banner" data-width="1000" data-height="400">
        <div class="banner-slider--banner" style="width: 100%; ">
            <div class="gen-custom-banner-slider"  >                
                <div class="indextop--container">
                    <div class="indextop--cont-left">
                        <p class="indextop--cont-title">{s name='Xmastxt2'}Unser Adventsgeschenk <br> für Sie!{/s}</p> 
                        <div class="xmas21--door-cont">
                            <img class="xmas21--door-img ic" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="/custom/plugins/ApcXmas21ln/Resources/images/Desktop_Door_Ln.png" alt="" >
                            <div class="xmas--21-door-txts" id="xmas21--copy" data-copy="{$xmas21.code}">
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
                        <div class="xmas21--prs--name">
                            <div class="indextop-slider-prs">                                  
                                <p class="xmas21-slider-contr-discount">{$xmas21.percentValue}%</p>
                            </div>    
                            <div class="indextop--cont-name">
                                <p class="xmas21-slider-contr-artName-t">{$xmas21.articleName1}</p>
                                <p class="xmas21-slider-contr-artName-b">{$xmas21.articleName2}</p>
                            </div>
                        </div>                          
                        <a href="{if {$xmas21.sArticle}}{url controller=detail action=index sArticle={$xmas21.sArticle}}{else}{url controller=index}{$xmas21.url}{/if}" class="indextop--cont-btn is--secondary btn">{s name='Xmastxt3'}Jetzt entdecken{/s}</a>
                    </div>
                    <div class="indextop--cont-right">
                        <a href="{if {$xmas21.sArticle}}{url controller=detail action=index sArticle={$xmas21.sArticle}}{else}{url controller=index}{$xmas21.url}{/if}">
                            <img class="indextop--slider-img ic" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-src="{if $xmas21.img != x}/custom/plugins/ApcXmas21ln/Resources/images/Products/{$xmas21.img}{else}{link file='frontend/_public/src/img/no-picture.jpg'}{/if}" alt="" >
                        </a>    
                    </div>
                </div>
            </div>
        </div>
    </div>   
{/if}    