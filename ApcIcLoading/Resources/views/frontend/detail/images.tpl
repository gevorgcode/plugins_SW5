{extends file="parent:frontend/detail/images.tpl"}

{block name='frontend_detail_image_thumbs_main_img'}
    <picture>
        {block name='frontend_detail_image_thumbs_main_img_source'}{/block}
        {block name='frontend_detail_image_thumbs_main_img_img'}
            <img class="ic thumbnail--image"
                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                 data-srcset="{$sArticle.image.thumbnails[0].sourceSet}"
                 alt="{s name="DetailThumbnailText" namespace="frontend/detail/index"}{/s}: {$alt}"
                 title="{s name="DetailThumbnailText" namespace="frontend/detail/index"}{/s}: {$alt|truncate:160}"
            />
        {/block}
    </picture>

    {block name='frontend_detail_image_thumbs_main_img_no_script'}
        <noscript>{$smarty.block.parent}</noscript>
    {/block}
{/block}

{block name='frontend_detail_image_thumbs_images_img'}
    <picture>
        {block name='frontend_detail_image_thumbs_images_img_source'}{/block}
        {block name='frontend_detail_image_thumbs_images_img_img'}
            <img class="ic thumbnail--image"
                 src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                 data-srcset="{$image.thumbnails[0].sourceSet}"
                 alt="{s name="DetailThumbnailText" namespace="frontend/detail/index"}{/s}: {$alt}"
                 title="{s name="DetailThumbnailText" namespace="frontend/detail/index"}{/s}: {$alt|truncate:160}"
            />
        {/block}
    </picture>

    {block name='frontend_detail_image_thumbs_images_img_no_script'}
        <noscript>{$smarty.block.parent}</noscript>
    {/block}
{/block}
