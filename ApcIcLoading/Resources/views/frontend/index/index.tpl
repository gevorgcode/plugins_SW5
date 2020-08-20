{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_header_javascript_inline"}
    {$smarty.block.parent}

    {block name="frontend_index_header_javascript_inline_icload"}
        var apcIcLoadingEffect = '{$apcIcLoadingEffect}',
            apcIcLoadingEffectTime = '{$apcIcLoadingEffectTime}',
            apcIcLoadingInstantLoad = ('{$apcIcLoadingInstantLoad}' === '1'),
            apcIcLoadingPreloadAfterLoad = ('{$apcIcLoadingPreloadAfterLoad}' === '1');
    {/block}
{/block}
