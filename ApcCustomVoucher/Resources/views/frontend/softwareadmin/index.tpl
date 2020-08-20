{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'} 
    <div class="container" style="padding: 40px 0;">
       <div style="display: flex; justify-content: space-between">
            <h2 style="color: #203e45; padding-bottom: 50px;">Admin page</h2>
            <h2 style="color: #203e45; padding-bottom: 50px;">
                <form style=""  method="post" action="{url controller=Softwareadmin action='logout'}" >
                    <button style="background: none; border: none; color: #66b0b8;" type="submit">Logout</button>
                </form>            
            </h2>
        </div>
       {if {$changedLogin}}
           <div class="alert is--success is--rounded"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--check"></i> 
                 </div>
                 <div class="alert--content"> 
                     The status for <span style="padding: 5px; background: yellow;">"{$changedLogin}"</span> has been changed to "{if {$changedStatus} == 1}<span style="background: #c0cabf; padding: 5px;">Active</span>{else}<span style="background: #ffcfcf; padding: 5px;">Not active</span>{/if}" successfully.
                 </div> 
            </div>
       {/if}
       {if {$serialOrdernumber && $fromSerial} }
           <div class="alert is--success is--rounded"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--check"></i> 
                 </div>
                 <div class="alert--content"> 
                     The serials by article "{$serialOrdernumber}" created successfully.
                 </div> 
            </div>
       {/if}
       {if {$delSerialId && $fromDelete} }
           <div class="alert is--success is--rounded"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--check"></i> 
                 </div>
                 <div class="alert--content"> 
                     The serial deleted successfully.
                 </div> 
            </div>
       {/if}
       {if {$incorrectOrdernumber && $fromCreateserials} }
            <div class="alert is--error is--rounded" style="margin-bottom: 50px;"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--cross"></i> 
                 </div>
                 <div class="alert--content"> 
                     Product with this ordernumber ("{$incorrectOrdernumber}") does not exist.
                 </div> 
            </div>           
       {/if}
       
        <div class="creators" >
            <h2>Accounts</h2>
            <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                <tr>
                    <th>№</th>                    
                    <th>Login</th>
                    <th>Status</th>                    
                    <th>Free vuchers</th>
                    <th>Used vochers</th>
                    <th>Account created</th>                    
                    <th></th>                    
                </tr>
                {foreach $creators as $creator}
                    <tr class="row {if {$creator.creator_active}}active{else}not--active{/if}">
                        <td>{$creator@iteration}</td>                        
                        <td style="text-align: left">{$creator.creator_login}</td>
                        <td class="active--td">{if {$creator.creator_active}}Active {else}Not active*{/if}</td>                         
                        <td>{$creator.free_vouchers}</td>
                        <td>{$creator.used_vouchers}</td>
                        <td>{$creator.creator_create_date}</td>
                        <td>
                            <form method="post" action="{url controller=Softwareadmin action='viewcreator'}" >       
                                <input type="hidden" name="creatorlogin" value="{$creator.creator_login}">
                                <button type="submit" style="background: none; border: none; color: orange"><i class="icon--pencil"></i></button>
                            </form>
                        </td>                         
                    </tr>    
                {/foreach}
                <span style="font-size: 10px">*If status Not Active, the client can not access their account and create new vouchers, but previously created vouchers used.</span>
            </table>      
            <div style="display: flex; justify-content: space-between">
                 <form class="creatorlogin" style="width: 49%;" method="post" action="{url controller=Softwareadmin action='createcreator'}" >
                    <p class="container">Create account</p>
                    <input type="email" name="creatorlogin" placeholder="Email as login" minlength="4">
                    <input type="password" name="creatorpassword" placeholder="password" minlength="6">
                    <button type="submit" class="btn is--secondary">Create</button>
                </form>
                <div class="links" style="width: 49%; padding: 10px;">
                    <p>Useful links</p>
                    <p><span>Admin page:</span> <a href="/Softwareadmin" target="_blank">https://license-now.de//Softwareadmin</a> </p>                    
                    <p><span>Account page:</span> <a href="/Softwarecreator" target="_blank">https://license-now.de/Softwarecreator</a> </p>                    
                    <p><span>Voucher use page:</span> <a href="/gutschein" target="_blank">https://license-now.de/gutschein</a> </p>                    
                </div>
            </div>
            {if {$Serials}}
                <div class="free--serials">                   
                    <h2>All Serials</h2>
                    <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                        <tr>
                            <th>№</th>                    
                            <th>Ordernumber</th>
                            <th>Article name</th>
                            <th>Free count</th>
                            <th>Assigned to voucher</th>                            
                            <th></th>                                             
                        </tr>
                        {foreach $Serials as $Serial}
                            <tr style="height: 30px">
                                <td>{$Serial@iteration}</td>                                                      
                                <td>{$Serial.ordernumber}</td>
                                <td style="text-align: left">{$Serial.name}</td>
                                <td>{$Serial.free_count}</td>
                                <td>{$Serial.used_count}</td>
                                <td>
                                    <form method="post" action="{url controller=Softwareadmin action='createserials'}" >       
                                        <input type="hidden" name="ordernumber" value="{$Serial.ordernumber}">
                                        <button type="submit" style="background: none; border: none; color: orange"><i class="icon--pencil"></i></button>
                                    </form>
                                </td>                         
                            </tr>    
                        {/foreach}                       
                    </table> 
                </div>
            {/if}
            <div>
                <form class="creatorlogin" style="width: 49%;" method="post" action="{url controller=Softwareadmin action='createserials'}" >
                    <p style="margin: 0">Serials by article ordernumber</p>
                    <p style="font-size: 11px">You can see already imported serial-keys and import new ones</p>
                    <input type="text" name="ordernumber" placeholder="Article Ordernumber e.g. SW10001" >
                    <button class="btn is--secondary" type="submit">Next</button>
                </form>
                
            </div>           
                  
        </div>
       
    </div>
{/block}


    