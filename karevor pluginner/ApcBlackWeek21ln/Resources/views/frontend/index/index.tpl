{extends file='parent:frontend/index/index.tpl'}

{namespace name="ApcBlackWeek21/index"}

{block name='frontend_index_before_page'}
    {action module=widgets controller=bwcounter action=index}
    {$smarty.block.parent}
{/block}


{block name='index_slider_before_first_desctop_mob'}
    {$smarty.block.parent}
    {action module=widgets controller=bwcounter action=slider}    
{/block}

{block name='index_slider_before_first_desctop_mob_dot'}
    {$smarty.block.parent}
    {action module=widgets controller=bwcounter action=sliderdot}    
{/block}