{extends file='parent:frontend/index/topbar-navigation.tpl'}

{block name='frontend_index_top_bar_before_main_custom'}
    {action module=widgets controller=bwcounter action=index}
    {$smarty.block.parent}
{/block}