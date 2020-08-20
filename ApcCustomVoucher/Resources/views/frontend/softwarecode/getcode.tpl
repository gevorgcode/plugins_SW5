{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <form class="container" style="margin-top: 250px" method="post" action="{url controller=Softwarecode action='copycodes'}" >
        <input type="text" name="orderNumber" placeholder="ordernumber" >
        <input type="password" name="password" placeholder="password" >
        <input type="submit" >
    </form>
{/block}