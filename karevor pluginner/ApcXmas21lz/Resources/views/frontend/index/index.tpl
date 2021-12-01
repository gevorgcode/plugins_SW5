{extends file='parent:frontend/index/index.tpl'}

{block name='index_slider_before_first_desctop_mob'}
    {$smarty.block.parent}
    {action module=widgets controller=xmas21 action=index}    
{/block}

{block name='index_slider_before_first_desctop_mob_dot'}
    {$smarty.block.parent}
    {action module=widgets controller=xmas21 action=dot}    
{/block}