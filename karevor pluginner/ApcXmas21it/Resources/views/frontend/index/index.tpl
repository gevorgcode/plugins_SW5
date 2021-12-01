{extends file='parent:frontend/index/index.tpl'}

{{* desctop *}}
{block name='gen_custom_banner_slider_before_first_desctop'}    
    {action module=widgets controller=xmas21 action=index}
{/block}

{{* mobile *}}
{block name='gen_custom_banner_slider_before_first_mobile'}
    {action module=widgets controller=xmas21 action=indexmob}
{/block}