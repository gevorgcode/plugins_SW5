{extends file="parent:frontend/listing/product-box/product-image.tpl"}

{block name='frontend_listing_box_article_image_picture_element'}
    {block name="frontend_listing_box_article_image_picture_element_size"}
        {$imageSize = $apcIcLoadingProductImageSize}
        {if !$imageSize}
            {$imageSize = 0}
        {/if}
        {$image = $sArticle.image.thumbnails[$imageSize]}
    {/block}

    <picture>
        {block name='frontend_listing_box_article_image_picture_element_source'}{/block}
        {block name='frontend_listing_box_article_image_picture_element_img'}
            <img class="ic"
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                data-srcset="{$image.sourceSet}"
                alt="{$desc}"
                title="{$desc|truncate:160} "
                itemprop="thumbnailUrl"
            />
        {/block}
    </picture>

    {block name='frontend_listing_box_article_image_picture_element_no_script'}
        <noscript>{$smarty.block.parent}</noscript>
    {/block}
{/block}
