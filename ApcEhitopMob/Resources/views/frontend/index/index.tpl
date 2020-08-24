{extends file='parent:frontend/index/index.tpl'}

{* Shop header *}
{block name='frontend_index_navigation'}    
    {action module=widgets controller=ehitop action=index}
    {$smarty.block.parent}
{/block}