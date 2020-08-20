{extends file="parent:frontend/listing/product-box/box-big-image.tpl"}

{block name='frontend_listing_box_article_image_picture_element'}
    <picture>
        {block name='frontend_listing_box_article_image_picture_element_source'}{/block}
        {block name='frontend_listing_box_article_image_picture_element_img'}
            <img class="ic"
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                data-srcset="{$sArticle.image.thumbnails[1].sourceSet}"
                alt="{$desc}"
                title="{$desc|truncate:160}"
            />
        {/block}
    </picture>

    {block name='frontend_listing_box_article_image_picture_element_no_script'}
        <noscript>{$smarty.block.parent}</noscript>
    {/block}
{/block}
