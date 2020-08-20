{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    {if $voucherCodes}
        <h2 class="container" style="padding: 50px 0;">Voucher codes ({$countVoucherCodes}) for article {$orderNumber}</h2>
        <div class="container voucher--create" style="padding: 0 0 50px 0;">
            <p>Create Voucher Codes</p>
            <form  method="post" action="{url controller=Softwarecode action='createcode'}" >
                <input type="number" min="1" max="500" name="count_created_vouchers" placeholder="Count (1-500)"> 
                <input type="hidden" name="article_detail_id" value="{$articleDetailId}">
                <input type="hidden" name="article_order_number" value="{$orderNumber}">
                <button class="btn" type="submit">Create</button>
            </form>
        
        </div>
        <div class="container" style="display: flex; justify-content: space-between; border: 1px solid; border-radius: 10px; padding: 10px; margin-bottom: 30px;">            
            <div class="voucher--left">
                <p>Free voucher codes ({$NoAssignedCount})</p>
                {foreach $voucherCodes as $voucherCode}
                    {if {$voucherCode.voucher_name|count_characters} < 15}
                        <span>{$voucherCode.voucher_name}</span><br>
                    {/if}
                {/foreach}
            </div> 
            <div class="voucher--right">                
                 <p>Assigned voucher codes ({$AssignedCount})</p>
                 {foreach $voucherCodes as $voucherCode}
                    {if {$voucherCode.voucher_name|count_characters} > 15}
                        <span>{$voucherCode.voucher_name}</span><br>
                    {/if}
                {/foreach}
            </div>            
        </div>        
    {else}
        <div class="container" style="padding: 50px">
            <p>No voucher codes for article {$orderNumber}</p>
            <div class="container voucher--create" style="padding: 0 0 50px 0;">
                <p>Create Voucher Codes</p>
                <form  method="post" action="{url controller=Softwarecode action='createcode'}" >
                    <input type="number" min="1" max="500" name="count_created_vouchers" placeholder="Count (1-500)"> 
                    <input type="hidden" name="article_detail_id" value="{$articleDetailId}">               
                    <button class="btn" type="submit">Create</button>
                </form>

            </div>
        </div>
    {/if}
{/block}