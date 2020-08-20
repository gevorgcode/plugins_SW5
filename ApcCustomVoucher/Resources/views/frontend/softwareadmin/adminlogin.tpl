{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}    
    <form class="container" style="margin-top: 50px" method="post" action="{url controller=Softwareadmin action='loginadmin'}" >
       <h2 style="margin-bottom: 180px;">Admin</h2>
       <p class="container">Admin login</p>
        <input type="text" name="adminlogin" placeholder="Login" >
        <input type="password" name="password" placeholder="password" >
        <button type="submit" class="btn is--secondary btn--admin--login">Log in</button>        
    </form>
{/block}
