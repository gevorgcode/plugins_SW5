{extends file="parent:frontend/checkout/finish.tpl"}

  {* Main content *}
{block name="frontend_index_content"}
  
   {*}response params variable from ameria payment - $AmeriaPayParams{*}
   <div class="basket--info-messages">
       <div class="alert is--success is--rounded"> 
             <div class="alert--icon"> 
                <i class="icon--element icon--check"></i> 
             </div>
             <div class="alert--content"> 


                 
                     <div class="payment--info">

                             {if {$AmeriaPayParams.ResponseCode} == 00 }

                                     {if {$AmeriaPayParams.Currency} == '051'}
                                                     {$AmeriaPayParams.cur = 'AMD'}
                                             {else if {$AmeriaPayParams.Currency} == '643'}
                                                     {$AmeriaPayParams.cur = 'RUB'}
                                             {else if {$AmeriaPayParams.Currency} == '840'}
                                                     {$AmeriaPayParams.cur = 'USD'}
                                             {else if {$AmeriaPayParams.Currency} == '978'}
                                                     {$AmeriaPayParams.cur = 'EUR'}
                                             {else}
                                     {/if}
                                     <div class="payment--approved">
                                             <div class="approved--description">
                                                     <p>{s name='PaymentApprovedDescription' namespace='frontend/confirm/finish'}{/s}</p>
                                             </div>
                                             <div class="payment--information">
                                                     <p><span>{s name='PaymentApprovedAmount' namespace='frontend/confirm/finish'}{/s}:</span>  {$AmeriaPayParams.Amount} {$AmeriaPayParams.cur}</p>
                                                     <p><span>{s name='PaymentApprovedCardNumber' namespace='frontend/confirm/finish'}{/s}:</span>  {$AmeriaPayParams.CardNumber}</p>
                                                     <p><span>{s name='PaymentApprovedClientName' namespace='frontend/confirm/finish'}{/s}:</span>  {$AmeriaPayParams.ClientName}</p>
                                                     <p><span>{s name='PaymentApprovedDateTime' namespace='frontend/confirm/finish'}{/s}:</span>  {$AmeriaPayParams.DateTime}</p>
                                             </div>
                                     </div>




                             {else}
                                 <div>{s name='PaymentNotApprovedFinished' namespace='frontend/confirm/finish'}<a href="mailto:order@masisy.com">այստեղ:</a>{/s}</div>
                             {/if}
                     </div>

             </div> 
        </div>
    </div>    
{$smarty.block.parent}
{/block}