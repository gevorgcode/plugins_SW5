{extends file="parent:frontend/detail/image.tpl"}

{block name='frontend_detail_image_default_picture_element'}
    <picture>
        {block name='frontend_detail_image_default_picture_element_source'}{/block}
        {block name='frontend_detail_image_default_picture_element_img'}
            <img class="ic"
                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                 data-srcset="{$sArticle.image.thumbnails[1].sourceSet}"
                 alt="{$alt}"
                 itemprop="image"
            />
        {/block}
    </picture>

    {block name='frontend_detail_image_default_picture_element_no_script'}
        <noscript>{$smarty.block.parent}</noscript>
    {/block}
{/block}

{block name='frontend_detail_images_picture_element'}
    <picture>
        {block name='frontend_detail_images_picture_element_source'}{/block}
        {block name='frontend_detail_images_picture_element_img'}
            <img class="ic"
                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                 data-srcset="{$image.thumbnails[1].sourceSet}"
                 alt="{$alt}"
                 itemprop="image"
            />
        {/block}
    </picture>

    {block name='frontend_detail_images_picture_element_no_script'}
        <noscript>{$smarty.block.parent}</noscript>
    {/block}
{/block}
