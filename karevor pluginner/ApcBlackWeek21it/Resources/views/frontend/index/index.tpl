{extends file='parent:frontend/index/index.tpl'}

{namespace name="ApcBlackWeek21/index"}

{{* desctop *}}
{block name='gen_custom_banner_slider_before_first_desctop'}
    {$smarty.block.parent}
    {action module=widgets controller=bwcounter action=sliderdesc}    
{/block}

{{* mobile *}}
{block name='gen_custom_banner_slider_before_first_mobile'}
    {$smarty.block.parent}
    {action module=widgets controller=bwcounter action=slidermob}    
{/block}