{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}    
    <form class="container" style="margin-top: 50px" method="post" action="{url controller=Softwarecreator action='logincreator'}" >
       <h2 style="margin-bottom: 180px; color: #203e45">Account</h2>
       <p class="container">Account login</p>
        <input type="text" name="creatorlogin" placeholder="Login" >
        <input type="password" name="password" placeholder="password" >
        <button type="submit" class="btn is--secondary">Log in</button>        
    </form>
{/block}
