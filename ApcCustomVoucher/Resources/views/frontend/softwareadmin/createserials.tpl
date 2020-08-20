{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <div class="container" style="padding: 50px 0 10px 0">
       <h2 style="margin: 15px 0 50px 0;"> <a href="/Softwareadmin">Admin</a> > Serials : {$ordernumber}</h2>
       <form class="creatorlogin" style="width: 100%;" method="post" action="{url controller=Softwareadmin action='createserial'}" >
            <p class="container">Add new serials for article {$ordernumber} 
            <br>
            <span style="font-size: 11px">*one key can be imported more than once</span>
            </p>
            <input type="hidden" name="details_id" value="{$detailsId}">
            <input type="hidden" name="ordernumber" value="{$ordernumber}">
            <textarea rows="7" name="serials" style="height: 100%; width: 100%; margin: 20px 0" placeholder="Add new serials (separated by line breaks)"></textarea>
            <button type="submit" class="btn is--secondary">Add</button>
        </form>
    </div>
    <div class="container" style="padding: 10px 0; display: flex; justify-content: space-between">
        <div style="width: 70%">
             <h2>Free Serials ({$serilas|@count})</h2>
                <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                    <tr style="height: 30px">
                        <th>№</th>                    
                        <th>Serial-Key</th>                                                          
                        <th>Delete Key</th>                                                          
                    </tr>
                    {foreach $serilas as $serial}                        
                        <tr class="row {if {$serial.serial_assigned}}active{else}not--active{/if}">
                            <td style="text-align: center">{$serial@iteration}</td>                        
                            <td>{$serial.serial_number}</td>                                                     

                            <td style="text-align: center">
                               {if !{$serial.serial_assigned}}
                                    <form method="post" action="{url controller=Softwareadmin action='deleteserial'}" >       
                                        <input type="hidden" name="serial_id" value="{$serial.id}">
                                        <button type="submit" style="background: none; border: none; display: flex; margin: 0 auto"><i style="color: #ea6c6d; font-size: 20px" class="icon--minus2"></i></button>
                                    </form>
                                {/if}

                            </td>                         
                        </tr>                                         
                    {/foreach}                
            </table>        
        </div>   
        <div style="width: 28%">
             <h2>Serials Assigned to voucher ({$assignedSerilas|@count})</h2>
                <table style="margin-bottom: 30px; width: 100%; background: #203e45;">
                    <tr style="height: 30px">
                        <th>№</th>                    
                        <th>Serial-Key</th>                                                              
                    </tr>
                    {foreach $assignedSerilas as $serial}                        
                        <tr class="row {if {$serial.serial_assigned}}active{else}not--active{/if}">
                            <td style="text-align: center">{$serial@iteration}</td>                        
                            <td {if !{$serial.serial_assigned}} style="background: #87ec87"{/if}>{$serial.serial_number}</td>                                                     
                        </tr>                                            
                    {/foreach}                
            </table>        
        </div>   
    </div>
{/block}
