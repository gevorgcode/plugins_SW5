{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <div class="container" style="padding: 50px 0">
        <div style="display: flex; justify-content: space-between">
            <h2 style="color: #203e45; padding-bottom: 50px;"> <a href="/Softwarecreator">Account page</a> > {$ordernumber}</h2>
            <h2 style="color: #203e45; padding-bottom: 50px;">
                <form style=""  method="post" action="{url controller=Softwarecreator action='logout'}" >
                    <button style="background: none; border: none; color: #66b0b8;" type="submit">Logout</button>
                </form>            
            </h2>
        </div>       
        <div class="create">
            {if {$avilableserials|@count} > 0}
                <form style="border: 1px solid; border-radius: 10px; padding: 10px; width: 49%"  method="post" action="{url controller=Softwarecreator action='create'}" >
                    <p>Create Vouchers (avilable serial count for this article : {$avilableserials|@count})</p>
                    <input type="hidden" name="order_number" value="{$ordernumber}">
                    <input type="hidden" name="details_id" value="{$detailsId}">
                    <input type="hidden" name="creator_id" value="{$creatorId}">
                    <input type="number" required min="1" max="{$avilableserials|@count}" name="count_created_vouchers" placeholder="Count (1-{$avilableserials|@count})">            
                    <button class="btn is--secondary" type="submit" style="height: 34px; padding: 0 20px; width: 100%; text-align: center; margin-top: 20px;">Create</button>
                </form>                    
            {else}
                <div class="alert is--warning is--rounded" style="margin-top: 25px; "> 
                     <div class="alert--icon"> 
                        <i class="icon--element icon--warning"></i>
                     </div>
                     <div class="alert--content"> 
                         There are no serial-keys available to create vouchers for this article.
                     </div> 
                </div>                
            {/if}
        </div>      
        {if $vouchersOrdernumber}
            <h2>Vouchers for {$ordernumber}</h2>
            <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                <tr style="height: 30px">
                    <th>№</th>                    
                    <th>Voucher</th>
                    <th>Serial Id</th>                    
                    <th>Created</th>                    
                    <th>Voucher used</th>                    
                </tr>
                {foreach $vouchersOrdernumber as $voucher}
                    <tr>
                        <td style="text-align: center">{$voucher@iteration}</td>                        
                        <td style="text-align: center; {if !{$voucher.voucher_used}}background: #b3e2b3;{/if}">{$voucher.voucher_name}</td>
                        <td style="text-align: center">{$voucher.serial_id}</td>                        
                        <td style="text-align: center">{$voucher.voucher_create_date}</td>
                        <td style="text-align: center">{if {$voucher.voucher_used_date} == '0000-00-00 00:00:00'}-{else}{$voucher.voucher_used_date}{/if}</td>                         
                    </tr>    
                {/foreach}            
            </table>
        {/if}        
    </div>
{/block}