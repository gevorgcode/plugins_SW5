

{extends file='parent:frontend/index/index.tpl'}

{* Sidebar left *}
{block name='frontend_index_content_left'}{/block}



{block name="frontend_index_page_wrap"}
    <form style=" width: 200px; margin: 0 auto; margin-top: 50px; display: flex"  method="POST" action="{url controller=Httppassverify action=Very}" >
        <input placeholder="http password" type="password" name="http_pass" title="you can find pass in plugin configuration 'ApcHttpPass'" >
        <input type="submit">
    </form>   
{/block}
