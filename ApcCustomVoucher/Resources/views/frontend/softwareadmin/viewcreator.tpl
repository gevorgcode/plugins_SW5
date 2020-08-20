{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <div class="container" style="padding: 40px 0;">
        <h2 style="margin: 15px 0 50px 0;"> <a href="/Softwareadmin">Admin</a> > Account login: {$creator.creator_login}</h2>
        <div style="margin: 15px 0"> 
            <p><span style="font-weight: bold; margin-right: 5px;">Current Status: </span>{if {$creator.creator_active}}Active {else}Not active{/if}   </p>
                   
            <form style="display: flex" method="post" action="{url controller=Softwareadmin action='changestatus'}" >       
                <select name="status">
                    <option value="" disabled="disabled" selected="selected">Change status</option>
                    <option value="active">Active</option>
                    <option value="not active">Not Active</option>                    
                </select>
                <input type="hidden" name="creator_id" value="{$creator.id}">
                <button class="btn is--secondary"  type="submit" style="border: none; margin-left: 10px; height: 34px; padding: 0 30px;">Save</button>
            </form>                   
        </div>
        
        
        {if $creatorvouchers}
            <table style="margin-bottom: 30px; width: 100%; background: #203e45;" class="viewcreator">
                <tr style="height: 30px">
                    <th>№</th>                    
                    <th>Voucher code</th>
                    <th>Serial Id</th>                    
                    <th>Serial Key</th>                    
                    <th>Ordernumber</th>
                    <th>Voucher used by</th>
                    <th>Voucher email</th>
                    <th>Created</th>                                        
                    <th>Voucher used</th>                                        
                </tr>
                {foreach $creatorvouchers as $voucher}
                    <tr class="{if {$voucher.voucher_used}}tr--used{else}tr--free{/if}">
                        <td>{$voucher@iteration}</td>                        
                        <td class="td--used--free">{$voucher.voucher_name}</td>                                                
                        <td>{$voucher.serial_id}</td>
                        <td style="text-align: left">{$voucher.serial}</td>                          
                        <td>{$voucher.orderNumber}</td>
                        <td style="text-align: left">{if {$voucher.userlogin}}{$voucher.userlogin}{else}-{/if}</td>
                        <td style="text-align: left">{$voucher.voucher_email}</td>
                        <td>{$voucher.voucher_create_date}</td>
                        <td>{if $voucher.voucher_used_date == '0000-00-00 00:00:00'}-{else}{$voucher.voucher_used_date}{/if}</td>
                    </tr>    
                {/foreach}
            </table>    
        {else}
            <div class="alert is--warning is--rounded" style="margin: 25px 0;"> 
                 <div class="alert--icon"> 
                    <i class="icon--element icon--warning"></i>
                 </div>
                 <div class="alert--content"> 
                     No assigned vouchers for this account.
                 </div> 
            </div>            
            <a href="/Softwareadmin">Back</a>
        
        {/if}
        
                
           
    </div> 
{/block}

