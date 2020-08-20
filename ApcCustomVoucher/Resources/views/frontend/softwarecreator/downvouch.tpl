{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <div class="container" style="padding: 50px 0">
        <div style="display: flex; justify-content: space-between">
            <h2 style="color: #203e45;"> <a style="display: flex; align-items: center;" href="/Softwarecreator"><i class="icon--arrow-left3"></i> Back </a></h2>            
        </div>
        <div style="padding-bottom: 20px">
            {if $downVouch}
                <div class="free--serials">                   
                    <h2>Free vouchers ({$fromDate} to {$toDate})</h2>
                    <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                        <tr style="height: 30px;">
                            <th>№</th>                    
                            <th>Voucher</th>
                            <th>Serial Id</th>
                            <th>Ordernumber</th>
                            <th>Article name</th>                                            
                            <th>Created</th>

                        </tr>
                        {foreach $downVouch as $vouch}                            
                            <tr>
                                <td style="text-align: center">{$vouch@iteration}</td>                                                      
                                <td style="text-align: center">{$vouch.voucher_name}</td>
                                <td style="text-align: center">{$vouch.serial_id}</td>
                                <td style="text-align: center">{$vouch.ordernumber}</td>
                                <td style="text-align: left">{$vouch.articlename}</td>
                                <td style="text-align: center">{$vouch.voucher_create_date}</td>
                            </tr>                            
                        {/foreach}                       
                    </table> 
                </div>
            {else}
                <div class="alert is--error is--rounded" style="margin-bottom: 50px;"> 
                     <div class="alert--icon"> 
                        <i class="icon--element icon--cross"></i> 
                     </div>
                     <div class="alert--content"> 
                         You have no free vouchers from {$fromDate} to {$toDate}.
                     </div> 
                </div>
            {/if}
        </div>
    </div>    
{/block}