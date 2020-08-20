{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'}
    <div class="container" style="padding: 50px">
        <p>{$countCreatedVouchers} vouchers created successfully for article {$ordernumber}</p>
        <a href="/Softwarecode/getcode">Back</a>
    </div>    
{/block}
