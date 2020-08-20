{extends file="parent:frontend/listing/product-box/product-badges.tpl"}


 {* ESD product badge *}
{block name='frontend_listing_box_article_esd'}
    {$smarty.block.parent}   
    {if {$sArticle.usbArticle}}
        <div class="product--badge badge--usb">
            <i class="icon--usb">
                <img src="https://lizenzguru.de/media/image/d9/21/e8/USB-Flash-Drive-white.png" alt="" style="width: 25px;">
            </i>
        </div>
    {/if}
{/block}