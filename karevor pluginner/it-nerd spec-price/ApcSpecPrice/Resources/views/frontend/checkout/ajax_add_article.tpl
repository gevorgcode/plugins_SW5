{extends file="parent:frontend/checkout/ajax_add_article.tpl"}


{* Article price *}
{block name='checkout_ajax_add_information_price'}
    {if $specPriceAddArticle}
    <div class="article--price">
        <ul class="list--price list--unstyled">           
            <li class="entry--price">{if $specPrice}{$specPrice|currency}{else}{$sArticle.price|currency} {/if}{s name="Star" namespace="frontend/listing/box_article"}{/s}</li>
            <li class="entry--quantity">{s name="AjaxAddLabelQuantity"}{/s}: {$sArticle.quantity}</li>
        </ul>
    </div>
    {else}
        {$smarty.block.parent}
    {/if}
{/block}

