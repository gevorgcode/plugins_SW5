{extends file='parent:frontend/index/index.tpl'}

{block name='frontend_index_page_wrap'} 
    {block name='payment_ameria'}
        <div class="ameria-credit-agricole-bank-cc">
            <h2>Hello {$firstName} {$lastName}</h2>
            <h4>ՕՆԼԱՅՆ ՎՃԱՐՄԱՆ ՀԱՄԱԿԱՐԳ</h4>
            <h3>ԱԿԲԱ-ԿՐԵԴԻՏ ԱԳՐԻԿՈԼ ԲԱՆԿ</h3>
            <p>Դուք պատրաստվում եք վճարել {$amount} {$currency}․</p>
            <div class="pay--register-btns">
                <a class="btn is--secondary" href="{$cancelUrl}" title="cancel payment">Չեղարկել վճարումը</a>   
                <a class="btn is--primary" href="{$returnUrl}" title="pay {$amount} {$currency}">Մուտքագրել քարտի տվյալները</a>
            </div>                   
        </div>        
    {/block}
{/block}