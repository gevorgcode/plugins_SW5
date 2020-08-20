{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <div class="container" style="padding: 50px 0">
        <div style="display: flex; justify-content: space-between">
            <h2 style="color: #203e45; padding-bottom: 50px;">Account page > {$creatorLogin}</h2>
            <h2 style="color: #203e45; padding-bottom: 50px;">
                <form style=""  method="post" action="{url controller=Softwarecreator action='logout'}" >
                    <button style="background: none; border: none; color: #66b0b8;" type="submit">Logout</button>
                </form>            
            </h2>
        </div>
         {if $createOrdernumber && $createCount}
            <div class="alert is--success is--rounded" style="margin-bottom: 25px;"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--check"></i> 
                 </div>
                 <div class="alert--content">
                    {$createOrdernumber}: {$createCount} voucher(s) created successfully.                 
                 </div> 
            </div>
        {/if}
        <div style="display: flex; justify-content: space-between">
            <form style="border: 1px solid; border-radius: 10px; padding: 10px; width: 49%"  method="post" action="{url controller=Softwarecreator action='createcode'}" >
                <p>View and Create Vouchers by article ordernumber</p>
                <input type="text" required name="order_number" placeholder="Article Ordernumber e.g. SW10001">
                <input type="hidden" name="creator_id" value="{$creatorId}">
                <button class="btn is--secondary" type="submit">Next</button>
            </form>
            <div class="links" style="border: 1px solid; border-radius: 10px; padding: 10px; width: 49%">
                <p>Useful links</p>                            
                <p><span>Account page:</span> <a href="/Softwarecreator" target="_blank">https://license-now.de/Softwarecreator</a> </p>                    
                <p><span>Voucher use page:</span> <a href="/gutschein" target="_blank">https://license-now.de/gutschein</a> </p>                    
            </div>
        </div>   
        <div class="avilable--ordernumbers" style="padding-bottom: 20px">
            {if {$Serials}}
                <div class="free--serials">                   
                    <h2>Create voucher</h2>
                    <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                        <tr style="height: 30px;">
                            <th>№</th>                    
                            <th>Ordernumber</th>
                            <th>Article name</th>                                            
                            <th>Avilable count</th>
                            <th>Create</th>
                                                                      
                        </tr>
                        {foreach $Serials as $Serial}                            
                            <tr>
                                <td style="text-align: center">{$Serial@iteration}</td>                                                      
                                <td style="text-align: center">{$Serial.ordernumber}</td>
                                <td style="text-align: left">{$Serial.name}</td>
                                <td style="text-align: center">{$Serial.free_count}</td>
                                <td style="text-align: center" >                                    
                                    {if {$Serial.free_count}}
                                        <form style="display: flex; justify-content: space-around" method="post" action="{url controller=Softwarecreator action='create'}" >    
                                            <input type="number" style="width: 100px" required min="1" max="{$Serial.free_count}" name="count_created_vouchers" placeholder="count">
                                            <input type="hidden" name="order_number" value="{$Serial.ordernumber}">
                                            <input type="hidden" name="details_id" value="{$Serial.article_details_id}">
                                            <input type="hidden" name="creator_id" value="{$creatorId}">                                                                                
                                            <button type="submit" style="background: none; border: none; color: #6eb335; font-size: 20px"><i class="icon--plus2"></i></button>
                                        </form>                                        
                                    {/if}                                    
                                </td>
                                                        
                            </tr>                            
                        {/foreach}                       
                    </table> 
                </div>
            {/if}
        </div>
        
        
            <h2 style="margin-top: 0;">Search voucher code</h2>
            <div style="border: 1px solid; border-radius: 10px; padding: 20px;">                
                <form  method="post" action="{url controller=Softwarecreator action='searchvouch'}">                    
                        <span style="font-size: 12px">input format: xxxx-xxxx-xxxx&nbsp;</span>
                        <div style="display: flex">
                        <input type="text" name="vouchcode" placeholder="Enter voucher-code">
                        <input type="hidden" name="creator_id" value="{$creatorId}">                         
                    </div>                                                                              
                    <button class="btn is--secondary" type="submit">Search</button>
                </form> 
                
                 {if $freeVouch}
                     <h2>Search result</h2>
                     <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                        <tr style="height: 30px">                         
                            <th>Voucher</th>
                            <th>Serial Id</th>                    
                            <th>Ordernumber</th>
                            <th>Voucher used by</th>
                            <th>Voucher email</th>
                            <th>Created</th>                    
                            <th>Voucher used</th>                    
                        </tr>               
                        <tr>                                            
                            <td style="text-align: center; {if !{$freeVouch.voucher_used}}background: #b3e2b3;{/if}">{$freeVouch.voucher_name}</td>
                            <td style="text-align: center">{$freeVouch.serial_id}</td>                         
                            <td style="text-align: center">{$freeVouch.ordernumber}</td>
                            <td>{if {$freeVouch.assignuser}}{$freeVouch.assignuser}{else}-{/if}</td>
                            <td style="text-align: center">{$freeVouch.voucher_email}</td>
                            <td style="text-align: center">{$freeVouch.voucher_create_date}</td>
                            <td style="text-align: center">{if {$freeVouch.voucher_used_date} == '0000-00-00 00:00:00'}-{else}{$freeVouch.voucher_used_date}{/if}</td>                         
                        </tr>                          
                     </table>
                 {/if}
                 {if $usedVouch}
                     <h2>Search result</h2>
                     <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                        <tr style="height: 30px">                         
                            <th>Voucher</th>
                            <th>Serial Id</th>                    
                            <th>Ordernumber</th>
                            <th>Voucher used by</th>
                            <th>Voucher email</th>
                            <th>Created</th>                    
                            <th>Voucher used</th>                    
                        </tr>               
                        <tr>                                            
                            <td style="text-align: center; {if !{$usedVouch.voucher_used}}background: #b3e2b3;{/if}">{$usedVouch.voucher_name}</td>
                            <td style="text-align: center">{$usedVouch.serial_id}</td>                         
                            <td style="text-align: center">{$usedVouch.ordernumber}</td>
                            <td>{if {$usedVouch.assignuser}}{$usedVouch.assignuser}{else}-{/if}</td>
                            <td style="text-align: center">{$usedVouch.voucher_email}</td>
                            <td style="text-align: center">{$usedVouch.voucher_create_date}</td>
                            <td style="text-align: center">{if {$usedVouch.voucher_used_date} == '0000-00-00 00:00:00'}-{else}{$usedVouch.voucher_used_date}{/if}</td>                         
                        </tr>                          
                     </table>
                 {/if}
            </div>         
            <h2>Download free voucher codes by date</h2>
            <form style="border: 1px solid; border-radius: 10px; padding: 20px;" method="post" action="{url controller=Softwarecreator action='downvouch'}">
                <p>Date</p>
                <div style="display: flex">
                     <p style="padding: 5px 5px 5px 50px; border: 1px solid #203e45; border-radius: 10px; margin-right: 25px;">from: <input required type="date" name="fromdate" style="border: none; background: none;"></p>
                     <p style="padding: 5px 5px 5px 50px; border: 1px solid #203e45; border-radius: 10px;">to: <input required type="date" name="todate" style="border: none; background: none"></p> 
                     <input type="hidden" name="creator_id" value="{$creatorId}"> 
                     <input type="hidden" name="is_date" value="true"> 
                </div>                                                                              
                <button class="btn is--secondary" type="submit">Download</button>
            </form>         
        <h2>All your vouchers</h2>
        {if $vouchers}
        <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
            <tr style="height: 30px">
                <th>№</th>                    
                <th>Voucher</th>
                <th>Serial Id</th>                    
                <th>Ordernumber</th>
                <th>Voucher used by</th>
                <th>Voucher email</th>
                <th>Created</th>                    
                <th>Voucher used</th>                    
            </tr>
            {foreach $vouchers as $voucher}
                <tr>
                    <td style="text-align: center">{$voucher@iteration}</td>                        
                    <td style="text-align: center; {if !{$voucher.voucher_used}}background: #b3e2b3;{/if}">{$voucher.voucher_name}</td>
                    <td style="text-align: center">{$voucher.serial_id}</td>                         
                    <td style="text-align: center">{$voucher.ordernumber}</td>
                    <td>{if {$voucher.assignuser}}{$voucher.assignuser}{else}-{/if}</td>
                    <td style="text-align: center">{$voucher.voucher_email}</td>
                    <td style="text-align: center">{$voucher.voucher_create_date}</td>
                    <td style="text-align: center">{if {$voucher.voucher_used_date} == '0000-00-00 00:00:00'}-{else}{$voucher.voucher_used_date}{/if}</td>                         
                </tr>    
            {/foreach}            
        </table>   
        {else}
             <div class="alert is--warning is--rounded" style="margin: 25px 0;"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--warning"></i>
                 </div>
                 <div class="alert--content"> 
                     You have not created vouchers yet.
                 </div> 
            </div>
        {/if}                
           
    </div>
{/block}


