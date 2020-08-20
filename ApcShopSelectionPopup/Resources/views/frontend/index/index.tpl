{extends file="parent:frontend/index/index.tpl"}

{block name="frontend_index_page_wrap" prepend}
  {if $showLanguageBar}
       {action module='widgets' controller='VagShopSelectionController'}
  {/if}
{/block}